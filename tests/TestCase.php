<?php

namespace Darinlarimore\StatamicStripeFormField\Tests;

use Darinlarimore\StatamicStripeFormField\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('statamic-stripe-form-field.key', 'pk_test_fake_key');
        $app['config']->set('statamic-stripe-form-field.secret', 'sk_test_fake_secret');
    }
}
