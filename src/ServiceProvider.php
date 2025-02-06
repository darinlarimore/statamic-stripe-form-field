<?php

namespace Darinlarimore\StatamicStripeFormField;

use Statamic\Providers\AddonServiceProvider;
use Darinlarimore\StatamicStripeFormField\Fieldtypes\StripePayment;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/js/cp.js',
            'resources/css/cp.css',
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
