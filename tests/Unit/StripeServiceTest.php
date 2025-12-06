<?php

use Darinlarimore\StatamicStripeFormField\Services\StripeService;

it('initializes with stripe client', function () {
    $service = new StripeService();

    expect($service)->toBeInstanceOf(StripeService::class);
});

it('converts standard currency amounts correctly', function () {
    $service = new StripeService();
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('toStripeAmount');
    $method->setAccessible(true);

    $result = $method->invoke($service, 50.00, 'USD');
    expect($result)->toBe(5000.0);

    $result = $method->invoke($service, 25.50, 'EUR');
    expect($result)->toBe(2550.0);
});

it('converts zero-decimal currency amounts correctly', function () {
    $service = new StripeService();
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('toStripeAmount');
    $method->setAccessible(true);

    $result = $method->invoke($service, 1000, 'JPY');
    expect($result)->toBe(1000.0);

    $result = $method->invoke($service, 5000, 'KRW');
    expect($result)->toBe(5000.0);
});

it('handles all zero-decimal currencies', function () {
    $service = new StripeService();
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('toStripeAmount');
    $method->setAccessible(true);

    $zeroDecimalCurrencies = ['BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF'];

    foreach ($zeroDecimalCurrencies as $currency) {
        $result = $method->invoke($service, 1000, $currency);
        expect($result)->toBe(1000.0);
    }
});
