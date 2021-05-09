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
    $user = Auth::loginUsingId(1);
});

// Dashboard Routes...
Route::prefix("dashboard")->middleware(["auth", "status"])->name("dashboard.")->group(function () {

    Route::get("/", [DashboardController::class, "index"])->name("main");

    Route::prefix("profile")->name("profile.")->group(function () {
        Route::get("/", [ProfileController::class, "index"])->name("index");
        Route::put("update", [ProfileController::class, "update"])->name("update");
        Route::put("password-update", [ProfileController::class, "passwordUpdate"])->name("password.update");
    });

    Route::apiResource("permission", PermissionController::class)->middleware("access:permission");
    // Route::resource("role", RoleController::class)->middleware("access:role");
    // Route::resource("user", UserController::class)->middleware("access:user");

    // Route::name('ticket.')->middleware("access:ticket")->prefix('ticket')->group(function () {
    //     Route::get("/", [TicketController::class, "index"])->name('index');
    //     Route::post("side", [TicketController::class, "side"])->name('side');
    //     Route::post("content", [TicketController::class, "content"])->name('content');
    //     Route::post('changestatus', [TicketController::class, "changeStatus"])->name('change.status');
    //     Route::post('replay', [TicketController::class, "replay"])->name('replay');
    //     Route::get('append', [TicketController::class, "append"])->name('append');
    //     Route::post('append', [TicketController::class, "appendStore"])->name('append.store');
    // });

    // Route::name("credit.")->prefix('credit')->group(function () {
    //     Route::get('/', [CreditController::class, "index"])->name('index');
    //     Route::post('pay', [CreditController::class, "pay"])->name('pay');
    //     Route::get('response', [CreditController::class, "BankResponse"])->name('BankResponse');
    // });

    // Route::name("factor.")->prefix("factor")->group(function () {
    //     Route::get('payments', [FactorController::class, "payments"])->name("payments");
    // });

    // Route::resource("discount", DiscountController::class);

    // Route::prefix("option")->middleware("access:option")->name("option.")->group(function () {
    //     Route::get("/", [OptionController::class, "index"])->name("index");
    //     Route::post("/", [OptionController::class, "store"])->name("store");
    // });
});
