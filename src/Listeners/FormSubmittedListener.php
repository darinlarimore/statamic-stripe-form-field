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

        $form = $event->submission->form();
        $fields = $form->fields->all();


        $hasStripeField = collect($fields)->contains(function ($field) {
            return $field->type() === 'stripe_form';
        });

        if ($hasStripeField) {
            $stripeService = new StripeService();
            $field = $event->submission->form()->fields->first(function ($field) {
                return $field->type() === 'stripe_form';
            });

            $fieldConfig = $field->config();

            $fieldConfig = array_merge([
                'payment_type' => $fieldConfig['payment_type'] ?? 'once_off',
                'subscription_interval' => $fieldConfig['subscription_interval'] ?? 1,
                'subscription_frequency' => $fieldConfig['subscription_frequency'] ?? 'month',
                'payment_receipt' => $fieldConfig['payment_receipt'] ?? true,
                'receipt_email_field_handle' => $fieldConfig['receipt_email_field_handle'] ?? null,
                'payment_description' => $fieldConfig['payment_description'] ?? null,
                'amount' => $fieldConfig['amount'] ?? null,
                'fieldHandle' => $field->handle() ?? null,
            ]);

            $stripeService->handleFormPayment($event->submission, $fieldConfig);


            // Form::redirect($event->submission->form()->handle(), function (Submission $submission) {

            // });
        }
    }
}
