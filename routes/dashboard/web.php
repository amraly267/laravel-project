<?php

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        Route::prefix("dashboard")->name('dashboard.')->middleware('auth')->group(function () {

            // === Home Routes ===
            Route::get('home', 'dashboardCtrl@index')->name('home');

            // === Users Routes ===
            Route::resource('users', 'userCtrl')->except('show');

            // === Categories Routes ===
            Route::resource('categories', 'categoryCtrl')->except('show');

            // === Products Routes ===
            Route::resource('products', 'productCtrl')->except('show');

            // === Clients Routes ===
            Route::resource('clients', 'clientCtrl')->except('show');

            // === Orders Routes ===
            Route::resource('client.orders', 'orderCtrl')->except('show');

            // === Logout ===
            Route::get('logout', function () {
                Auth::logout();
                return Redirect::route('login');
            })->name('logout');

        });
    });


?>
