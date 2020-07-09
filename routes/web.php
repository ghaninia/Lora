<?php

Route::get('/' , function (){
   return redirect()->route('login') ;
}) ;

// Route Authunticate
Route::namespace("Auth\\")->group(function (){
    // Password Reset Routes...
    Route::prefix("password/")->group(function (){
        Route::name("password.")->group(function (){
            Route::get('reset', 'ForgotPasswordController@showLinkRequestForm')->name('request');
            Route::post('email', 'ForgotPasswordController@sendResetLinkEmail')->name('email');
            Route::get('reset/{token}', 'ResetPasswordController@showResetForm')->name('reset');
        });
        Route::post('reset', 'ResetPasswordController@reset');
    });
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

// Dashboard Routes...
Route::prefix("dashboard")->namespace('Dashboard')->middleware(["auth:user" , "status:user"])->name("dashboard.")->group(function (){

    Route::get("/" , 'DashboardController@index' )->name("main") ;
    Route::resource("profile" , "ProfileController")->only(['index' , 'store']);
    Route::resource("permission" , "PermissionController" , ['except' => ['show']])->middleware("access:permission") ;
    Route::resource("role" , "RoleController", ['except' => ['show']])->middleware("access:role") ;
    Route::resource("user" , "UserController" , ['except' => ['show'] ])->middleware("access:user") ;

    //ticket
    Route::name('ticket.')->middleware("access:ticket")->prefix('ticket')->group(function (){
        Route::get("/" , 'TicketController@index')->name('index') ;
        Route::post("side" , 'TicketController@side')->name('side') ;
        Route::post("content" , 'TicketController@content')->name('content') ;
        Route::post('changestatus' , 'TicketController@changeStatus')->name('changeStatus') ;
        Route::post('replay' , 'TicketController@replay')->name('replay') ;
        Route::get('append' , 'TicketController@append')->name('append') ;
        Route::post('append' , 'TicketController@appendStore')->name('appendStore') ;
    });

    //credit
    Route::name("credit.")->prefix('credit')->group(function (){
        Route::get('/' ,'CreditController@index')->name('index') ;
        Route::post('pay' ,'CreditController@pay')->name('pay') ;
        Route::get('response' ,'CreditController@BankResponse')->name('BankResponse') ;
    });

    //factors
    Route::name("factor.")->prefix("factor")->group(function (){
        Route::get('payments' , 'FactorController@payments')->name("payments") ;
    });

    //discount
    Route::resource("discount" , 'DiscountController') ;

    Route::prefix("option")->name("option.")->group(function (){
        Route::resource("/" , "OptionController" , ["only" => ["index" , "store"]])->middleware("access:option") ;
    });
});
