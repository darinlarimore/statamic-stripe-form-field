<?php

namespace Darinlarimore\StatamicStripeFormField;

use Statamic\Providers\AddonServiceProvider;
use Darinlarimore\StatamicStripeFormField\Fieldtypes\StripeForm;
use Illuminate\Support\Facades\Route;

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
        StripeForm::register();
    }
}
