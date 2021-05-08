<?php

use App\Http\Controllers\Dashboard\CreditController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DiscountController;
use App\Http\Controllers\Dashboard\FactorController;
use App\Http\Controllers\Dashboard\OptionController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\TicketController;
use App\Http\Controllers\Dashboard\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = User::find(2);
    return authunticate()->avatar() ;
});

// Route Authunticate
Route::namespace("Auth\\")->group(function () {
    //     // Password Reset Routes...
    //     Route::prefix("password/")->group(function (){
    //         Route::name("password.")->group(function (){
    //             Route::get('reset', 'ForgotPasswordController@showLinkRequestForm')->name('request');
    //             Route::post('email', 'ForgotPasswordController@sendResetLinkEmail')->name('email');
    //             Route::get('reset/{token}', 'ResetPasswordController@showResetForm')->name('reset');
    //         });
    //         Route::post('reset', 'ResetPasswordController@reset');
    //     });
    //     // Authentication Routes...
    //     Route::get('login', 'LoginController@showLoginForm')->name('login');
    //     Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

// Dashboard Routes...
Route::prefix("dashboard")->middleware(["auth" , "status"])->name("dashboard.")->group(function () {
    Route::get("/", [DashboardController::class, "index"])->name("main");

    Route::resource("profile", ProfileController::class )->only(['index', 'store']);

    Route::resource("permission", PermissionController::class)->middleware("access:permission");
    Route::resource("role", RoleController::class)->middleware("access:role");
    Route::resource("user", UserController::class)->middleware("access:user");

    Route::name('ticket.')->middleware("access:ticket")->prefix('ticket')->group(function () {
        Route::get("/", [TicketController::class, "index"])->name('index');
        Route::post("side", [TicketController::class, "side"])->name('side');
        Route::post("content", [TicketController::class, "content"])->name('content');
        Route::post('changestatus', [TicketController::class, "changeStatus"])->name('changeStatus');
        Route::post('replay', [TicketController::class, "replay"])->name('replay');
        Route::get('append', [TicketController::class, "append"])->name('append');
        Route::post('append', [TicketController::class, "appendStore"])->name('appendStore');
    });

    Route::name("credit.")->prefix('credit')->group(function () {
        Route::get('/', [CreditController::class, "index"])->name('index');
        Route::post('pay', [CreditController::class, "pay"])->name('pay');
        Route::get('response', [CreditController::class, "BankResponse"])->name('BankResponse');
    });

    Route::name("factor.")->prefix("factor")->group(function () {
        Route::get('payments', [FactorController::class, "payments"])->name("payments");
    });

    Route::resource("discount", DiscountController::class);

    Route::prefix("option")->middleware("access:option")->name("option.")->group(function () {
        Route::get("/", [OptionController::class, "index"])->name("index");
        Route::post("/", [OptionController::class, "store"])->name("store");
    });
});
