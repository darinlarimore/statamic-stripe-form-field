<?php

use Darinlarimore\StatamicStripeFormField\Fieldtypes\StripePayment;

it('has correct icon', function () {
    $fieldtype = new StripePayment;

    $reflection = new ReflectionClass($fieldtype);
    $iconProperty = $reflection->getProperty('icon');
    $iconProperty->setAccessible(true);

    expect($iconProperty->getValue($fieldtype))->toContain('<svg');
});

it('is categorized as special', function () {
    $fieldtype = new StripePayment;

    $reflection = new ReflectionClass($fieldtype);
    $categoriesProperty = $reflection->getProperty('categories');
    $categoriesProperty->setAccessible(true);

    expect($categoriesProperty->getValue($fieldtype))->toContain('special');
});

it('is selectable in forms', function () {
    $fieldtype = new StripePayment;

    $reflection = new ReflectionClass($fieldtype);
    $selectableProperty = $reflection->getProperty('selectableInForms');
    $selectableProperty->setAccessible(true);

    expect($selectableProperty->getValue($fieldtype))->toBeTrue();
});

it('has correct keywords', function () {
    $fieldtype = new StripePayment;

    $reflection = new ReflectionClass($fieldtype);
    $keywordsProperty = $reflection->getProperty('keywords');
    $keywordsProperty->setAccessible(true);
    $keywords = $keywordsProperty->getValue($fieldtype);

    expect($keywords)->toContain('stripe')
        ->and($keywords)->toContain('payment')
        ->and($keywords)->toContain('credit card')
        ->and($keywords)->toContain('checkout');
});

it('returns correct view name', function () {
    $fieldtype = new StripePayment;

    expect($fieldtype->view())->toBe('statamic-stripe-form-field::forms.fields.stripe_form_field');
});

it('provides stripe api key in extra renderable data', function () {
    config(['statamic-stripe-form-field.key' => 'pk_test_example']);

    $fieldtype = new StripePayment;
    $data = $fieldtype->extraRenderableFieldData();

    expect($data)->toHaveKey('api_key')
        ->and($data['api_key'])->toBe('pk_test_example');
});

it('has amount config field', function () {
    $fieldtype = new StripePayment;

    $reflection = new ReflectionClass($fieldtype);
    $method = $reflection->getMethod('configFieldItems');
    $method->setAccessible(true);
    $fields = $method->invoke($fieldtype);

    expect($fields)->toHaveKey('amount')
        ->and($fields['amount']['type'])->toBe('text')
        ->and($fields['amount']['validate'])->toContain('required')
        ->and($fields['amount']['validate'])->toContain('numeric');
});

it('has currency config field', function () {
    $fieldtype = new StripePayment;

    $reflection = new ReflectionClass($fieldtype);
    $method = $reflection->getMethod('configFieldItems');
    $method->setAccessible(true);
    $fields = $method->invoke($fieldtype);

    expect($fields)->toHaveKey('currency')
        ->and($fields['currency']['type'])->toBe('text')
        ->and($fields['currency']['default'])->toBe('USD')
        ->and($fields['currency']['validate'])->toContain('required');
});

it('has payment description config field', function () {
    $fieldtype = new StripePayment;

    $reflection = new ReflectionClass($fieldtype);
    $method = $reflection->getMethod('configFieldItems');
    $method->setAccessible(true);
    $fields = $method->invoke($fieldtype);

    expect($fields)->toHaveKey('payment_description')
        ->and($fields['payment_description']['type'])->toBe('text');
});

it('has receipt email field handle config field', function () {
    $fieldtype = new StripePayment;

    $reflection = new ReflectionClass($fieldtype);
    $method = $reflection->getMethod('configFieldItems');
    $method->setAccessible(true);
    $fields = $method->invoke($fieldtype);

    expect($fields)->toHaveKey('receipt_email_field_handle')
        ->and($fields['receipt_email_field_handle']['type'])->toBe('text');
});
