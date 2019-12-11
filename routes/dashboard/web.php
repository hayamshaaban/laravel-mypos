<?php

     Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 

        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){
   
            Route::get('/index','DashboardController@index')->name('index');
            Route::resource('users','UserController')->except(['show']);
            Route::resource('categories','CategoryController')->except(['show']);
            Route::resource('products','ProductController')->except(['show']);
            Route::resource('clients','ClientController')->except(['show']);
            Route::resource('clients.orders','Client\OrderController')->except(['show']);


            
        });   
    });

