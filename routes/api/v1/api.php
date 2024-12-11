<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\UpdateProfileController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\Auth\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::group(['namespace' => 'Api\V1'], function () {
    
    // Product routes
    Route::group(['prefix' => 'products'], function () {
        Route::get('popular', 'ProductController@get_popular_products');
        Route::get('recommended', 'ProductController@get_recommended_products');
        Route::get('drinks', 'ProductController@get_drinks');
        Route::get('by-type/{type}', 'ProductController@getProductByType');
        Route::get('type/{articleTypeId}', 'ProductController@getArticlesByType');
        Route::get('allproducts', 'ProductController@getAllProducts');
        Route::get('product/{id}', 'ProductController@getProductDetails');

    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('article-types', 'ArticleTypeApiController@index');
          // New route for getting products by type

    });
    Route::group(['prefix' => 'banners'], function () {
       Route::get('get-all', 'BannerApiController@index'); // Get all banners
        Route::get('{id}', 'BannerController@show'); // Get a specific banner
        Route::post('/', 'BannerController@store'); // Create a new banner
        Route::put('{id}', 'BannerController@update'); // Update a specific banner
        Route::delete('{id}', 'BannerController@destroy'); // Delete a specific banner
    });

    // Authentication routes
    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        Route::post('register', 'Customer1AuthController@register');
        Route::post('login', 'Customer1AuthController@login')->name('login');
        //    Route::post('login', [Customer1AuthController::class,'login'])->name('login');
        
        // Password reset routes
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'ForgotPasswordController@reset')->name('password.reset');

        Route::post('password/reset', 'ForgotPasswordController@reset')->name('password.update');


        // Protected routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('change-password', 'Customer1AuthController@changePassword');
            Route::post('profile/update', 'UpdateProfileController@updateProfile');
        });

        // Email verification routes
        Route::post('verify-email', 'Customer1AuthController@verify')->name('verification.verify');
        Route::post('verify-email/{id}/{hash}', 'Customer1AuthController@verify')->name('verification.verify'); // Ensure this matches the intended functionality
    });

    // Customer routes
    Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {
        Route::get('info', 'CustomerController@info');
        Route::get('info1', 'ClientController@info');
        Route::post('update-profile', 'CustomerController@update_profile');
        Route::post('update-cagnotte', 'ClientController@updateCagnotte');

        Route::get('deal-frequence/{clientId}', 'DealFrequenceController@calculateDealFrequence');



        Route::post('update-interest', 'CustomerController@update_interest');
        Route::put('cm-firebase-token', 'CustomerController@update_cm_firebase_token');
        Route::get('suggested-articles', 'CustomerController@get_suggested_article');
         

       

        // Address routes
        Route::group(['prefix' => 'address'], function () {
            Route::get('list', 'ClientController@address_list');
            Route::post('add', 'ClientController@add_new_address');
            Route::put('update/{id}', 'ClientController@update_address');
            Route::delete('delete', 'ClientController@delete_address');
        });

        // Order routes
        Route::group(['prefix' => 'order'], function () {
            Route::get('list', 'OrderController@get_order_list');
            Route::get('running-orders', 'OrderController@get_running_orders');
            Route::get('details', 'OrderController@get_order_details');
            Route::post('place', 'OrderController@place_order');
            Route::put('cancel', 'OrderController@cancel_order');
            Route::put('refund-request', 'OrderController@refund_request');
            Route::get('track', 'OrderController@track_order');
            Route::put('payment-method', 'OrderController@update_payment_method');
        });


          // Payment routes
    Route::group(['prefix' => 'payment'], function () {
        // Payment initiation route (you can replace the route name as needed)
        Route::post('payment', 'PaymentController@payment');
        Route::get('success', 'PaymentController@success');
        Route::get('fail', 'PaymentController@fail');
    });
    });



    // Configuration routes
    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@configuration');
        Route::get('/get-zone-id', 'ConfigController@get_zone');
        Route::get('place-api-autocomplete', 'ConfigController@place_api_autocomplete');
        Route::get('distance-api', 'ConfigController@distance_api');
        Route::get('place-api-details', 'ConfigController@place_api_details');
        Route::get('geocode-api', 'ConfigController@geocode_api');
    });

    // Deals routes (to be implemented)
    Route::group(['prefix' => 'deal'], function () {
        // Add deal routes here
    });

    Route::group(['prefix' => 'dealdepense'], function () {
    Route::get('dealdepense', 'DealDepenseController@getDealDepenseInfo');
    Route::post('create', [DealDepenseController::class, 'store']);
    Route::get('{id}', [DealDepenseController::class, 'show']);
});

    // Deal information routes
    Route::get('offre', 'OffreController@getDealOffreInfo');
    Route::get('dealDepense', 'DealDepenseController@getDealDepenseInfo');
    Route::get('dealMarque', 'DealMarqueController@getDealMarqueInfo');
    Route::get('dealFrequence', 'DealFrequenceController@getDealFrequenceInfo');
    Route::get('dealAnniversaire', 'DealAnniversaireController@getDealAnniversaireInfo');


    
});
