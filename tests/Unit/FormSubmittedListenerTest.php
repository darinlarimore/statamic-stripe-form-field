<?php

use Darinlarimore\StatamicStripeFormField\Listeners\FormSubmittedListener;
use Darinlarimore\StatamicStripeFormField\Services\StripeService;
use Illuminate\Validation\ValidationException;
use Mockery\MockInterface;
use Statamic\Contracts\Forms\Submission;
use Statamic\Events\FormSubmitted;

function makeField(string $type, string $handle = 'payment', array $config = []): MockInterface
{
    $field = Mockery::mock();
    $field->shouldReceive('type')->andReturn($type);
    $field->shouldReceive('handle')->andReturn($handle);
    $field->shouldReceive('config')->andReturn($config);

    return $field;
}

function makeEvent(array $fields, array $data): FormSubmitted
{
    $form = Mockery::mock();
    $form->fields = collect($fields);

    $dataCollection = collect($data);

    $submission = Mockery::mock(Submission::class);
    $submission->shouldReceive('form')->andReturn($form);
    $submission->shouldReceive('data')->andReturn($dataCollection);

    return new FormSubmitted($submission);
}

beforeEach(function () {
    $this->stripeService = Mockery::mock(StripeService::class);
    $this->listener = new FormSubmittedListener($this->stripeService);
});

it('does nothing when form has no stripe_payment field', function () {
    $this->stripeService->shouldNotReceive('handleFormPayment');

    $event = makeEvent([makeField('text', 'name')], ['name' => 'Alice']);

    $this->listener->handle($event);
});

it('does nothing when stripe_payment field has no token', function () {
    $this->stripeService->shouldNotReceive('handleFormPayment');

    $event = makeEvent([makeField('stripe_payment', 'payment')], []);

    $this->listener->handle($event);
});

it('charges via stripe service and stores receipt url on submission data', function () {
    $field = makeField('stripe_payment', 'payment', [
        'amount' => 25.00,
        'currency' => 'USD',
        'payment_description' => 'Test charge',
        'receipt_email_field_handle' => 'email',
    ]);

    $event = makeEvent([$field], [
        'payment' => 'tok_visa',
        'email' => 'buyer@example.com',
    ]);

    $this->stripeService
        ->shouldReceive('handleFormPayment')
        ->once()
        ->with(Mockery::on(fn ($config) => $config['token'] === 'tok_visa'
            && $config['amount'] === 25.00
            && $config['currency'] === 'USD'
            && $config['description'] === 'Test charge'
            && $config['receipt_email'] === 'buyer@example.com'
        ))
        ->andReturn('https://stripe.com/receipt/abc');

    $this->listener->handle($event);

    expect($event->submission->data()->get('payment'))->toBe('https://stripe.com/receipt/abc');
});

it('omits receipt_email when no handle is configured', function () {
    $field = makeField('stripe_payment', 'payment', [
        'amount' => 10.00,
        'currency' => 'USD',
    ]);

    $event = makeEvent([$field], ['payment' => 'tok_visa']);

    $this->stripeService
        ->shouldReceive('handleFormPayment')
        ->once()
        ->with(Mockery::on(fn ($config) => $config['receipt_email'] === null))
        ->andReturn('https://stripe.com/receipt/xyz');

    $this->listener->handle($event);
});

it('wraps stripe errors in ValidationException', function () {
    $field = makeField('stripe_payment', 'payment', [
        'amount' => 25.00,
        'currency' => 'USD',
    ]);

    $event = makeEvent([$field], ['payment' => 'tok_invalid']);

    $this->stripeService
        ->shouldReceive('handleFormPayment')
        ->andThrow(new \Exception('Your card was declined.'));

    expect(fn () => $this->listener->handle($event))
        ->toThrow(ValidationException::class);
});
