<?php

namespace Darinlarimore\StatamicStripeFormField;

use Darinlarimore\StatamicStripeFormField\Fieldtypes\StripePayment;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/js/cp.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function bootAddon()
    {
        StripePayment::register();

        $this->publishes([
            __DIR__.'/../resources/views/forms/fields' => resource_path('views/vendor/statamic-stripe-form-field/forms/fields'),
        ], 'statamic-stripe-form-field-views');
    }
}
