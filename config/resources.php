<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Allowed API Resources
    |--------------------------------------------------------------------------
    |
    | This array contains the list of resources that are allowed to be accessed
    | through the API endpoints. Add or remove resources as needed.
    |
    */
    'allowed' => [
        'products',
        'sellers',
        'payment_methods',
        'product_offers',
        'questions',
        'reviews',
    ],

    /*
    |--------------------------------------------------------------------------
    | Resource Validation Rules
    |--------------------------------------------------------------------------
    |
    | Additional configuration for resource validation can be added here
    | in the future if needed.
    |
    */
    'validation' => [
        'enabled' => true,
        'case_sensitive' => false,
    ],
];
