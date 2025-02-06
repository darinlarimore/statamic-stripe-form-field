<?php

return [
    'key' => env('STRIPE_PUBLISHABLE_KEY'),
    'secret' => env('STRIPE_SECRET_KEY'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SIGNING_SECRET'),
];
