<?php
namespace Darinlarimore\StatamicStripeFormField\Services;

use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;

class StripeService
{
	private StripeClient $client;

	public function __construct()
	{
		$this->client = new StripeClient(config('statamic-stripe-form-field.secret'));
	}

	public function handleFormPayment($submission, array $fieldConfig): array
	{
		try {
			$paymentData = $this->buildPaymentData($submission, $fieldConfig);
			return $fieldConfig['payment_type'] === 'subscription'
				? $this->handleSubscription($paymentData, $fieldConfig)
				: $this->handleOneTimePayment($paymentData);
		} catch (ApiErrorException $e) {
			throw new \Exception("Payment failed: {$e->getMessage()}");
		}
	}

	protected function buildPaymentData($submission, array $fieldConfig): array
	{
		$data = [
			'confirm' => true,
			'amount' => ($fieldConfig['amount'] ?? 0) * 100,
			'currency' => $fieldConfig['currency'] ?? 'usd',
			'description' => $fieldConfig['payment_description'] ?? '',
			'metadata' => [
				'form_id' => $submission->form()->handle(),
				'submission_id' => $submission->id(),
			],
			'automatic_payment_methods' => [
				'enabled' => true,
				'allow_redirects' => 'never',
			],
			'confirmation_token' => $submission->get($fieldConfig['fieldHandle']),
			'return_url' => '',
		];

		if (!empty($fieldConfig['receipt_email_field_handle'])) {
			$emailHandle = $fieldConfig['receipt_email_field_handle'];
			$data['receipt_email'] = $submission->get($emailHandle);
		}
		return $data;
	}

	protected function handleOneTimePayment(array $paymentData): array
	{
		$intent = $this->client->paymentIntents->create($paymentData);

		return [
			'type' => 'payment',
			'client_secret' => $intent->client_secret,
			'payment_intent_id' => $intent->id,
		];
	}

	protected function handleSubscription(array $paymentData, array $fieldConfig): array
	{
		if (empty($paymentData['receipt_email'])) {
			throw new \Exception('Email required for subscriptions.');
		}
		$customerId = $this->getOrCreateCustomer($paymentData['receipt_email']);
		$subscription = $this->client->subscriptions->create([
			'customer' => $customerId,
			'items' => [[
				'price_data' => [
					'currency' => $paymentData['currency'],
					'unit_amount' => $paymentData['amount'],
					'product_data' => [
						'name' => $fieldConfig['subscription_description'] ?? 'Subscription',
					],
					'recurring' => [
						'interval' => $fieldConfig['subscription_frequency'] ?? 'month',
						'interval_count' => $fieldConfig['subscription_interval'] ?? 1,
					],
				],
			]],
			'metadata' => $paymentData['metadata'],
			'payment_behavior' => 'default_incomplete',
		]);
		return [
			'type' => 'subscription',
			'client_secret' => $subscription->latest_invoice->payment_intent->client_secret ?? null,
			'subscription_id' => $subscription->id,
		];
	}

	public function createPaymentMethod(array $cardData): string
	{

		$expiry = explode('/', $cardData['expiry']);
		$cardData['exp_month'] = trim($expiry[0]);
		$cardData['exp_year'] = trim($expiry[1]);

		try {
			$paymentMethod = $this->client->paymentMethods->create([
				'type' => 'card',
				'card' => [
					'number' => $cardData['number'],
					'exp_month' => $cardData['exp_month'],
					'exp_year' => $cardData['exp_year'],
					'cvc' => $cardData['cvc'],
				],
			]);

			return $paymentMethod->id;
		} catch (ApiErrorException $e) {
			throw new \Exception("Payment method creation failed: {$e->getMessage()}");
		}
	}

	protected function getOrCreateCustomer(string $email): string
	{
		try {
			$existing = $this->client->customers->search(['query' => "email:'$email'"]);
			return $existing->data[0]->id ?? $this->client->customers->create(['email' => $email])->id;
		} catch (ApiErrorException $e) {
			throw new \Exception("Customer creation failed: {$e->getMessage()}");
		}
	}

}

