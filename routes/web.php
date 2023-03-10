<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RazorpayController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('{any?}', function() {
    return view('application');
})->where('any', '.*');



Route::group(['prefix' => '/payment'], function () {
    Route::post('/pay-check', [RazorpayController::class, 'Payment']);
    Route::post('/make-payment',[RazorpayController::class,'pay'])->name('make.payment');
    Route::post('/status', [RazorpayController::class,'paymentCallback'])->name('status');
});
