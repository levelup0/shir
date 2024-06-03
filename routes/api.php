<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\MassActionController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SubscriptionMonthController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Api\LanguagesController;
use App\Http\Controllers\Admin\SubscriptionsController;
use App\Http\Controllers\Admin\SubscriptionOptionsController;
use App\Http\Controllers\Admin\SubscriptionPriceCurrencyController;
use App\Http\Controllers\Admin\UserChatsController;
use App\Http\Controllers\Admin\UserMessagesController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\UserRoomsController;
use App\Http\Controllers\Api\AproveController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\CategoryVozController;
use App\Http\Controllers\Api\CvController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SubscriptionsController as SubscriptionsControllerApi;
use App\Http\Controllers\Api\UserSubscriptionsController;
use App\Http\Controllers\Api\VozController;
use App\Http\Controllers\Api\VozMainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Lk\TmcBrandController;
use App\Http\Controllers\Lk\TmcController;
use App\Http\Controllers\Lk\TmcLocationController;
use App\Http\Controllers\Lk\TmcNamesController;
use App\Http\Controllers\Lk\TmcTypesController;
use App\Http\Controllers\Lk\TmcModelController;
use App\Http\Controllers\Lk\TmcObjectController;
use App\Http\Controllers\Lk\TmcUnitController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/login', [IndexController::class, 'create'])->name('login');

Route::group([
    // 'namespace' => 'Api', 
    'prefix' => 'v1',
    'middleware' => ['lang'],
], function () {

    Route::get('/testdata', [IndexController::class, 'testData']);
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::get('get-user', [AuthenticationController::class, 'getUser'])->middleware('auth:api');
    Route::get('countries', [AuthenticationController::class, 'getCountries'])->middleware('auth:api');

    Route::post('login', [AuthenticationController::class, 'store']);
    Route::post('login-google', [AuthenticationController::class, 'storeGoogle']);

    Route::post('logout', [AuthenticationController::class, 'destroy'])->middleware('auth:api');
  
    Route::apiResource('languages', LanguagesController::class);

    /**
     * Subscriptions
     */

      /**
     * Subscription Options
     */
    Route::resource('subscriptions', SubscriptionsControllerApi::class)->only([
        'index',
        'show',
    ]);

    /**
     * User Subscription Options
     */
    Route::get('user-subscriptions', [UserSubscriptionsController::class, 'getSubscriptions'])->middleware('auth:api');
   
    /**
     * Currency
     */
    Route::get('currency', [CurrencyController::class, 'index'])->middleware('auth:api');

     /**
     * Category Voz
     */
    Route::get('category-voz', [CategoryVozController::class, 'index']);
   
     /**
     * Subscription Month
     */
    Route::get('subscription-month', [SubscriptionMonthController::class, 'index']);

    /**
     * Balance
     */
    Route::get('balance', [BalanceController::class, 'index'])->middleware('auth:api');
    
    /**
     * Balance
     */
    Route::post('buy', [UserSubscriptionsController::class, 'buy'])->middleware('auth:api');

    /**
     * Вызовы
     */
    Route::resource('voz', VozController::class)->only([
        'index',
        'store',
        'show',
        'destroy'
    ])->middleware('auth:api');;

    Route::post('voz/{voz}', [VozController::class, 'update'])->middleware('auth:api');

    Route::post('voz-update-status', [VozController::class, 'updateStatus'])->middleware('auth:api');

    /**
     * CV
     */
    Route::resource('cv', CvController::class)->only([
        'index',
        'store',
        'show',
        'destroy'
    ])->middleware('auth:api');;

    Route::post('cv/{cv}', [CvController::class, 'update'])->middleware('auth:api');

    Route::get('contact-assets/{id}', [CvController::class, 'contactAssets']);
    Route::get('contact-assets-voz-files/{id}', [CvController::class, 'contactAssetsVozFiles']);

    /**
     * Voz Main
     */
    Route::resource('voz-main', VozMainController::class)->only([
        'index',
        'show',
    ]);

    /**
     * Mass action
     */
    Route::apiResource('mass-action', MassActionController::class);

    Route::post('user-password-update', [AuthenticationController::class, 'passwordUpdate'])->middleware('auth:api');

    // Route::get('contact-assets/{id}', 'Api\CvController@contactAssets');  

     /**
     * Users
     */
    Route::resource('users', UsersController::class)->only([
        'index',
        'store',
        'show',
        'destroy'
    ]);
    Route::post('users/{user}', [UsersController::class, 'update']);

     /**
     * Aprove
     */
    Route::resource('aprove', AproveController::class)->only([
        'index',
        'store',
        'show',
        'destroy'
    ])->middleware('auth:api');;

    Route::post('aprove/{aprove}', [AproveController::class, 'update'])->middleware('auth:api');

    Route::post('aprove-update-status', [AproveController::class, 'updateStatus'])->middleware('auth:api');
    
});

Route::group([
    'prefix' => 'lk',
], function () {
    
    // Auth functionality
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('admin_password_update', [AuthController::class, 'updatePassword'])->middleware('auth:api');
    Route::post('logout', [AuthenticationController::class, 'destroy'])->middleware('auth:api');

    Route::get('users', [AuthController::class, 'user']);

    /**
     * Mass action
     */
    Route::apiResource('mass-action', MassActionController::class);


   

    /**
     * Roles
     */
    Route::resource('roles', RolesController::class)->only([
        'index',
        'store',
        'show',
        'destroy'
    ]);
    Route::post('roles/{role}', [RolesController::class, 'update']);

     /**
     * Subscriptions
     */
    // Route::resource('subscriptions-admin', SubscriptionsController::class)->only([
    //     'index',
    //     'store',
    //     'show',
    //     'destroy'
    // ]);
    // Route::post('subscriptions-admin/{subscription}', [SubscriptionsController::class, 'update']);

    /**
     * Subscription Options
     */
    // Route::resource('subscription-options-admin', SubscriptionOptionsController::class)->only([
    //     'index',
    //     'store',
    //     'show',
    //     'destroy'
    // ]);
    // Route::post('subscription-options-admin/{subscriptionOptions}', [SubscriptionOptionsController::class, 'update']);
 
    /**
     * Countries
     */
    // Route::resource('countries-admin', CountriesController::class)->only([
    //     'index',
    //     'store',
    //     'show',
    //     'destroy'
    // ]);
    // Route::post('countries-admin/{countriesAdmin}', [CountriesController::class, 'update']);
 
 
     /**
     * Subscription price currency admin
     */
    Route::resource('subscription-price-admin', SubscriptionPriceCurrencyController::class)->only([
        'index',
        'store',
        'show',
        'destroy'
    ]);
    Route::post('subscription-price-admin/{subscriptionPriceAdmin}', [SubscriptionPriceCurrencyController::class, 'update']);

     /**
     * Currency Admin
     */
    // Route::resource('currency-admin', CurrencyController::class)->only([
    //     'index',
    //     'store',
    //     'show',
    //     'destroy'
    // ]);
    // Route::post('currency-admin/{currencyAdmin}', [CurrencyController::class, 'update']);

    /**
     * Subscription Month Admin
     */
    Route::resource('subscription-month-admin', SubscriptionMonthController::class)->only([
        'index',
        'store',
        'show',
        'destroy'
    ]);
    Route::post('subscription-month-admin/{subscriptionMonthAdmin}', [SubscriptionMonthController::class, 'update']);


});
 
