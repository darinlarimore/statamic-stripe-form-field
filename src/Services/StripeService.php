<?php

namespace Darinlarimore\StatamicStripeFormField\Services;

use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;

class StripeService
{
    private StripeClient $client;



    public function __construct()
    {
        $this->client = new StripeClient([
            'api_key' => config('statamic-stripe-form-field.secret'),
            'stripe_version' => '2025-01-27.acacia',
        ]);
    }

    public function handleFormPayment($config): string
    {
        try {
            $config = (object) $config;
            $receiptEmail = $config->receipt_email ? ['receipt_email' => $config->receipt_email] : [];

            $charge = $this->client->charges->create([
                'amount' => $this->toStripeAmount($config->amount, $config->currency),
                'currency' => strtolower($config->currency),
                'description' => $config->description,
                'source' => $config->token,
                ...$receiptEmail,
            ]);

            return $charge->receipt_url;
        } catch (ApiErrorException $error) {
            throw new \Exception("Payment failed: {$error->getMessage()}");
        }
    }

    private function toStripeAmount(float $amount, string $currency): float
    {
        // https://stripe.com/docs/currencies#zero-decimal
        $zeroDecimalCurrencies = ['BIF','CLP','DJF','GNF','JPY','KMF','KRW','MGA','PYG','RWF','UGX','VND','VUV','XAF','XOF','XPF'];

        if (in_array(strtoupper($currency), $zeroDecimalCurrencies)) {
            return (int) $amount;
        }

        return ceil($amount * 100);
    }
}
