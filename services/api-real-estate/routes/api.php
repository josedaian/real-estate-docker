<?php

use App\Enums\PriceTypes;
use App\Http\Controllers\Pricing\GetPriceM2ByZipCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('price-m2')->group(function(){
    Route::prefix('zip-codes')->group(function(){
        Route::get('/{zipCode}/aggregate/{priceType}', GetPriceM2ByZipCodeController::class)->whereIn('priceType', ['min', 'max', 'avg']);
    });
});
