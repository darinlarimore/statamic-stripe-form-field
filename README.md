# <img src="readmeAssets/icon.svg" height="50" width="50"> Statamic Stripe Form Field

A Statamic addon that adds Stripe payment functionality to your forms.

![Front End Example](/readmeAssets/frontendExample.png)

## Features
- Seamless integration with Statamic forms
- Support for one-time payments
- Customizable payment amounts and currencies
- Optional email receipts
- Real-time card validation
- Secure payment processing using Stripe Elements
- Does not store any sensitive payment information, PCI compliant.

## Installation

1. Require the package using Composer:
```bash
composer require darinlarimore/statamic-stripe-form-field
```

2. Add your Stripe API keys to your `.env` file:
Visit the [Stripe Dashboard](https://dashboard.stripe.com/apikeys) to create API keys.
```
STRIPE_PUBLISHABLE_KEY=your_publishable_key
STRIPE_SECRET_KEY=your_secret_key
```

## Setup Field in a Form's Blueprint
![Stripe Payment](/readmeAssets/fieldType.png)

Add the "Stipe Payment" field to your form blueprint and configure the field settings.

### Field settings:
- `Amount` (required): The amount to charge the customer.
- `Currency` (required): [A three-letter ISO currency code supported by Stripe.](https://docs.stripe.com/currencies#presentment-currencies)
- `Payment Description` (optional): Enter a description for this payment. It will appear on the transaction in your Stripe account, and on the payment receipt sent to the customer.
- `Receipt Email Field Handle` (optional): The field handle of the email field in your form that should be used to send the payment receipt to the customer. If left blank, the customer will not receive a receipt.

## Customize the Field Template
You can customize the field template by publishing the field view to your site's views directory:
```bash
php artisan vendor:publish --tag=statamic-stripe-form-field-views
```
