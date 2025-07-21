<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DataController;

// Rutas para la Versión 1 de nuestra API
Route::prefix('v1')->group(function () {
    // Ruta para obtener la lista de un recurso (e.g., /api/v1/products)
    Route::get('/{resource}', [DataController::class, 'index'])->where('resource', '[a-zA-Z_]+');

    // Ruta para obtener el detalle de un item (e.g., /api/v1/products/1)
    Route::get('/{resource}/{id}', [DataController::class, 'show'])->where('resource', '[a-zA-Z_]+')->whereNumber('id');
});
