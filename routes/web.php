<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'API Laravel',
        'version' => '1.0.0',
        'endpoints' => '/api/*'
    ]);
});
