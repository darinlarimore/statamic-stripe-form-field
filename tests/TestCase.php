<?php

namespace Darinlarimore\StatamicStripeFormField\Tests;

use Darinlarimore\StatamicStripeFormField\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
