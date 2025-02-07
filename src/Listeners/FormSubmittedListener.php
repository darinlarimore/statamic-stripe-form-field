<?php

namespace Darinlarimore\StatamicStripeFormField\Listeners;

use Statamic\Events\FormSubmitted;
use Statamic\Facades\Form;
use Statamic\Forms\Submission;
use Darinlarimore\StatamicStripeFormField\Services\StripeService;

class FormSubmittedListener
{
    public function handle(FormSubmitted $event)
    {
        $field = $event->submission->form()->fields->first(function ($field) {
            return $field->type() === 'stripe_payment';
        });


        if ($field) {
            $token = $event->submission->data()->get($field->handle());
            if ($token) {
                $stripeService = new StripeService();

                $fieldConfig = $field->config();

                $fieldConfig = array_merge([
                    'receipt_email' => $event->submission->data()->get($fieldConfig['receipt_email_field_handle'] ?? '') ,
                    'description' => $fieldConfig['payment_description'] ?? '',
                    'amount' => $fieldConfig['amount'] ?? '',
                    'currency' => $fieldConfig['currency'] ?? 'USD',
                    'token' => $token ?? '',
                ]);

                $receiptUrl = $stripeService->handleFormPayment($fieldConfig);
                $event->submission->data()->put('payment', $receiptUrl);
            }
        }
    }
}
