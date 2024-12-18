<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\ClientController;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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

Route::get('/', function () {
    return redirect('/admin');
    // return view('welcome');
});

Route::group(['prefix' => 'payment-mobile'], function () {
        Route::get('/', 'PaymentController@payment')->name('payment-mobile');
        Route::get('set-payment-method/{name}', 'PaymentController@set_payment_method')->
            name('set-payment-method');
    });
    Route::post('pay-paypal', 'PaypalPaymentController@payWithpaypal')->name('pay-paypal');
    Route::get('paypal-status', 'PaypalPaymentController@getPaymentStatus')->name('paypal-status');
    Route::get('payment-success', 'PaymentController@success')->name('payment-success');
    Route::get('payment-fail', 'PaymentController@fail')->name('payment-fail');


    // Notification Controllers
    Route::post('send',[PushNotificationController::class, 'bulksend'])->name('bulksend');
    Route::get('all-notifications', [PushNotificationController::class, 'index']);
    Route::get('get-notification-form', [PushNotificationController::class, 'create']);
    Route::post('send','MyController@bulksend')->name('bulksend');

    // Route::post('reset_password_without_token', 'AccountsController@validatePasswordRequest');
    // Route::post('reset_password_with_token', 'AccountsController@resetPassword');


    // Route::post('/marques', [MarqueController::class, 'create']);
    // Route::delete('/marques/{id}', [MarqueController::class, 'delete']);
    // Route::put('/marques/{id}', [MarqueController::class, 'edit']);

    // Route::get('/manage-marques', 'MarqueController@index')->name('manage.marques');
    // Route::post('/marquees', 'MarqueController@store')->name('marquees.store');


    Route::get('/test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('karem.lazhar@gmail.com')
                ->subject('Test Email');
    });
    return 'Email Sent';
});


    Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    //Route::view('password/reset/success', 'auth.passwords.reset_success')->name('password.reset.success');
    Route::get('password/reset/success', function () {
    return view('auth.passwords.reset_success');
})->name('password.success');
    Route::get('password/request', function () {
    return view('auth.passwords.request'); // Adjust the view name as needed
})->name('password.request');
