<?php

namespace Darinlarimore\StatamicStripeFormField\Fieldtypes;

use Statamic\Fields\Fieldtype;

class StripeForm extends Fieldtype
{
    protected $icon = '<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M69.3142 49.8054C69.3142 51.8118 69.0104 53.3531 68.4027 54.429C67.8527 55.4468 67.1004 55.9557 66.1458 55.9557C65.4803 55.9557 64.8872 55.8248 64.3663 55.5629V45.7921C65.2054 44.9197 66.0301 44.4835 66.8402 44.4835C68.4896 44.4835 69.3142 46.2576 69.3142 49.8054ZM88.3247 48.235H83.5503C83.7237 45.3852 84.5339 43.9603 85.9809 43.9603C87.4566 43.9603 88.2378 45.3852 88.3247 48.235ZM20.6597 54.1237C20.6597 52.408 20.1823 51.0776 19.2274 50.1325C18.2726 49.1874 16.8114 48.3513 14.8437 47.6243C13.8021 47.2463 13.0498 46.8974 12.5868 46.5775C12.1241 46.2575 11.8927 45.894 11.8927 45.487C11.8927 44.7309 12.4424 44.3529 13.542 44.3529C15.2202 44.3529 17.0142 44.8327 18.9239 45.7923L19.7047 40.9069C17.7661 39.9763 15.6105 39.5111 13.2378 39.5111C11.0098 39.5111 9.23024 40.0636 7.89922 41.1686C6.51034 42.3027 5.81589 43.8876 5.81589 45.9232C5.81589 47.6098 6.28609 48.9257 7.22648 49.8708C8.16688 50.8159 9.60642 51.6374 11.5451 52.3353C12.6735 52.7423 13.462 53.1131 13.9105 53.4476C14.3588 53.782 14.583 54.1818 14.583 54.6471C14.583 55.5486 13.8886 55.9993 12.4997 55.9993C11.6606 55.9993 10.6478 55.8176 9.4615 55.4541C8.27514 55.0906 7.23346 54.6472 6.33648 54.1237L5.55523 59.0528C7.63858 60.245 10.0691 60.8412 12.8469 60.8412C15.1906 60.8412 17.0569 60.3032 18.4458 59.2272C19.9216 58.035 20.6597 56.3338 20.6597 54.1237ZM33.4635 44.7454L34.2885 39.9037H30.1218V34.015L24.5229 34.931L23.7421 39.9037L21.7456 40.2529L21.0081 44.7458H23.6991V54.2985C23.6991 56.7412 24.3357 58.486 25.6088 59.5329C26.7083 60.4053 28.3142 60.8415 30.4265 60.8415C31.3524 60.8415 32.4954 60.6815 33.8553 60.3616V55.2145C32.9294 55.4183 32.2928 55.5202 31.9456 55.5202C30.7303 55.5202 30.1227 54.7932 30.1227 53.3392V44.7461L33.4635 44.7454ZM47.1788 45.8359V39.7728C46.7449 39.6857 46.3398 39.6421 45.9635 39.6421C45.0376 39.6421 44.2347 39.8747 43.5547 40.3398C42.8747 40.8049 42.3901 41.4737 42.1007 42.3462L41.6667 39.9037H35.9809V60.4486H42.4913V47.1009C43.2437 46.1994 44.43 45.7487 46.0503 45.7487C46.5131 45.7487 46.8893 45.7779 47.1788 45.8359ZM48.7847 60.4486H55.2952V39.9037H48.7847V60.4486ZM75.7812 49.5873C75.7812 46.0395 75.1302 43.4368 73.8281 41.7793C72.6707 40.2671 71.0648 39.5111 69.0104 39.5111C67.1586 39.5111 65.4659 40.3253 63.9323 41.9538L63.5848 39.9037H57.8557V68.0384L64.3661 66.9479V60.3613C65.4078 60.6812 66.3915 60.8412 67.3174 60.8412C69.7191 60.8412 71.6577 60.0269 73.1334 58.3984C74.8985 56.5083 75.7812 53.5712 75.7812 49.5873ZM55.4687 34.4076C55.4687 33.4479 55.136 32.6337 54.4705 31.9648C53.805 31.296 52.9948 30.9616 52.0399 30.9616C51.0851 30.9616 50.2749 31.296 49.6093 31.9648C48.9438 32.6337 48.6111 33.4479 48.6111 34.4076C48.6111 35.3672 48.9438 36.1887 49.6093 36.8721C50.2749 37.5554 51.0851 37.8971 52.0399 37.8971C52.9948 37.8971 53.805 37.5554 54.4705 36.8721C55.136 36.1887 55.4687 35.3672 55.4687 34.4076ZM94.4444 49.9798C94.4444 46.6938 93.75 44.1348 92.3611 42.3028C90.9144 40.4416 88.831 39.5111 86.1111 39.5111C83.3333 39.5111 81.1415 40.4707 79.5356 42.39C77.9297 44.3092 77.1267 46.9264 77.1267 50.2415C77.1267 53.9638 78.0382 56.6973 79.8611 58.4421C81.4525 60.0415 83.7818 60.8412 86.8489 60.8412C89.7714 60.8412 92.0862 60.2596 93.7934 59.0963L93.0992 54.6035C91.45 55.505 89.5981 55.9557 87.5437 55.9557C86.2995 55.9557 85.3881 55.6793 84.8093 55.1266C84.1438 54.5738 83.7387 53.6142 83.5941 52.2477H94.358C94.4158 51.8406 94.4444 51.085 94.4444 49.9798ZM100 21.5834V77.4166C100 78.9288 99.4502 80.2374 98.3507 81.3424C97.2512 82.4475 95.9491 83 94.4444 83H5.55556C4.05092 83 2.74884 82.4475 1.64931 81.3424C0.549769 80.2374 0 78.9288 0 77.4166V21.5834C0 20.0712 0.549769 18.7626 1.64931 17.6576C2.74884 16.5525 4.05092 16 5.55556 16H94.4444C95.9491 16 97.2512 16.5525 98.3507 17.6576C99.4502 18.7626 100 20.0712 100 21.5834Z" fill="white"/> </svg> ';

    protected $categories = ['special'];

    protected $selectableInForms = true;

    protected $keywords = ['stripe', 'payment', 'credit card', 'checkout'];

    public function view()
    {
        return 'statamic-stripe-form-field::forms.fields.stripe_form_field';
    }

    public function extraRenderableFieldData(): array
    {
        return [
            'api_key' => config('statamic-stripe-form-field.key'),
            'amount' => $this->config('amount'),
            'currency' => $this->config('currency'),
        ];
    }


    protected function configFieldItems(): array
    {
        return [

            'payment_type' => [
                'display' => 'Payment Type',
                'instructions' => 'Choose the type of payment form you want to display.',
                'type' => 'select',
                'default' => 'once_off',
                'options' => [
                    'once_off' => __('Once Off'),
                    'subscription' => __('Subscription'),
                ],
            ],
            'subscription_interval' => [
                'display' => 'Subscription Interval',
                'instructions' => 'Choose the interval of the subscription payments.',
                'type' => 'text',
                'input_type' => 'number',
                'default' => 1,
                'validate' => 'required|numeric',
                'if' => [
                    'payment_type' => 'subscription',
                ],
            ],
            'subscription_frequency' => [
                'display' => 'Subscription Frequency',
                'instructions' => 'Choose the frequency of the subscription payments.',
                'type' => 'select',
                'default' => 'month',
                'options' => [
                    'day' => __('Day'),
                    'week' => __('Week'),
                    'month' => __('Month'),
                    'year' => __('Year'),
                ],
                'if' => [
                    'payment_type' => 'subscription',
                ],
            ],
            'subscription_description' => [
                'display' => 'Subscription Description',
                'instructions' => 'Enter a description for the subscription. This will only be shown in Stripe.',
                'type' => 'text',
                'if' => [
                    'payment_type' => 'subscription',
                ],
            ],

            'amount' => [
                'display' => 'Amount',
                'instructions' => 'The amount to charge the customer.',
                'type' => 'text',
                'input_type' => 'number',
                'placeholder' => '0',
                'validate' => [
                    'numeric',
                    'min:0',
                    'max:99999',
                    'required'
                ],
            ],
            'currency' => [
                'display' => 'Currency',
                'instructions' => 'A three-letter <a href="https://www.iso.org/iso-4217-currency-codes.html" target="_blank">ISO currency code</a> supported by Stripe.',
                'type' => 'text',
                'default' => 'USD',
                'validate' => [
                    'required',
                    'size:3',
                ],
            ],
            'payment_description' => [
                'display' => 'Payment Description',
                'instructions' => 'Enter a description for this payment, to appear against the transaction in your Stripe account, and on the payment receipt sent to the customer.',
                'type' => 'text',
            ],
            'payment_receipt' => [
                'display' => 'Payment Receipt',
                'instructions' => 'Whether Stripe should email a receipt to the customer on successful payment.',
                'type' => 'toggle',
                'default' => true,
            ],
            'receipt_email_field_handle' => [
                'display' => 'Receipt Email Field Handle',
                'instructions' => 'The field handle of the email field in your form that should be used to send the payment receipt to the customer.',
                'type' => 'text',
                'if' => [
                    'payment_receipt' => true,
                ],
            ],
        ];
    }
}
