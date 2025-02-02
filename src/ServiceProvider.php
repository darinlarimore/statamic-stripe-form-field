<?php

namespace Darinlarimore\StatamicStripeFormField;

use Statamic\Providers\AddonServiceProvider;
use Darinlarimore\StatamicStripeFormField\Fieldtypes\StripeForm;

class ServiceProvider extends AddonServiceProvider
{

    protected $vite = [
        'input' => [
            'resources/js/main.js',
            'resources/css/main.css'
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function bootAddon()
    {
        StripeForm::register();
    }
}
