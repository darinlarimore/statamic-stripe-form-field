<?php

use Darinlarimore\StatamicStripeFormField\Listeners\FormSubmittedListener;

it('creates a listener instance', function () {
    $listener = new FormSubmittedListener;

    expect($listener)->toBeInstanceOf(FormSubmittedListener::class);
});

it('has handle method', function () {
    $listener = new FormSubmittedListener;

    expect(method_exists($listener, 'handle'))->toBeTrue();
});
