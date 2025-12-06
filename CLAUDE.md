# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Statamic addon that adds Stripe payment functionality to Statamic forms. It's a Laravel/Statamic package that integrates Stripe Elements for secure payment processing on form submissions.

## Development Commands

### Build & Development
- `npm run dev` - Start Vite development server for frontend assets (Vue 2 components for Statamic control panel)
- `npm run build` - Build production assets (CSS/JS for control panel)

### Installation in Development
```bash
composer require darinlarimore/statamic-stripe-form-field
```

### Publishing Views (for customization)
```bash
php artisan vendor:publish --tag=statamic-stripe-form-field-views
```

## Architecture

### Core Components

**ServiceProvider** (`src/ServiceProvider.php`)
- Registers the StripePayment fieldtype
- Configures Vite build for control panel assets (`resources/js/cp.js`, `resources/css/cp.css`)
- Sets up publishable views

**StripePayment Fieldtype** (`src/Fieldtypes/StripePayment.php`)
- Custom Statamic fieldtype for payment forms
- Config fields: `amount`, `currency`, `payment_description`, `receipt_email_field_handle`
- Provides Stripe publishable key to frontend via `extraRenderableFieldData()`
- Uses Antlers template: `statamic-stripe-form-field::forms.fields.stripe_form_field`

**StripeService** (`src/Services/StripeService.php`)
- Handles Stripe API communication using `stripe/stripe-php` SDK
- `handleFormPayment()` creates charges and returns receipt URL
- Handles zero-decimal currencies (JPY, KRW, etc.) via `toStripeAmount()`
- Uses Stripe API version `2025-01-27.acacia`

**FormSubmittedListener** (`src/Listeners/FormSubmittedListener.php`)
- Hooks into Statamic's `FormSubmitted` event
- Processes payment when a form with `stripe_payment` field is submitted
- Stores receipt URL in submission data under `payment` key
- Throws `ValidationException` on Stripe errors

### Frontend Implementation

**Antlers Template** (`resources/views/forms/fields/stripe_form_field.antlers.html`)
- Uses Alpine.js (`x-init`) to dynamically load Stripe.js
- Creates Stripe Elements card input
- Generates token on card completion and stores in hidden input
- Displays inline validation errors

**Control Panel** (`resources/js/cp.js`, `resources/js/components/StripePayment.vue`)
- Vue 2 component for Statamic control panel fieldtype
- Built with Vite and Laravel Vite plugin
- Registered as `stripe_payment-fieldtype` component

### Configuration

**Config File** (`config/statamic-stripe-form-field.php`)
- `key`: Stripe publishable key (from `STRIPE_PUBLISHABLE_KEY` env)
- `secret`: Stripe secret key (from `STRIPE_SECRET_KEY` env)

### Payment Flow

1. User fills out form with Stripe payment field
2. Stripe Elements validates card and creates token (frontend)
3. Token stored in hidden input field
4. Form submission triggers `FormSubmittedListener`
5. Listener extracts token and field config (amount, currency, description, receipt email)
6. `StripeService` creates charge via Stripe API
7. Receipt URL stored in submission data
8. On error, `ValidationException` thrown to display error to user

## Key Implementation Details

- **Currency Handling**: Zero-decimal currencies (e.g., JPY, KRW) are handled differently - amount is not multiplied by 100
- **Receipt Email**: Configured via `receipt_email_field_handle` which references another form field's handle
- **Token Security**: Stripe tokens are one-time use and handled client-side via Stripe.js
- **Error Handling**: Stripe API errors wrapped in Laravel `ValidationException` for form display
- **PCI Compliance**: No sensitive card data stored, all handled by Stripe Elements

## Environment Requirements

- Node version specified in `.nvmrc`
- PHP with Statamic ^5.46 and stripe/stripe-php ^16.5
- Stripe API keys in `.env` (STRIPE_PUBLISHABLE_KEY, STRIPE_SECRET_KEY)
