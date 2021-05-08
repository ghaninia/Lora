<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Services\User\UserServiceInterface::class, \App\Services\User\UserService::class);
        $this->app->bind(\App\Services\Transaction\TransactionServiceInterface::class, \App\Services\Transaction\TransactionService::class);
        $this->app->bind(\App\Services\Ticket\TicketServiceInterface::class, \App\Services\Ticket\TicketService::class);
        $this->app->bind(\App\Services\Role\RoleServiceInterface::class, \App\Services\Role\RoleService::class);
        $this->app->bind(\App\Services\Permission\PermissionServiceInterface::class, \App\Services\Permission\PermissionService::class);
        $this->app->bind(\App\Services\Payment\PaymentServiceInterface::class, \App\Services\Payment\PaymentService::class);
        $this->app->bind(\App\Services\Option\OptionServiceInterface::class, \App\Services\Option\OptionService::class);
        $this->app->bind(\App\Services\Discount\DiscountServiceInterface::class, \App\Services\Discount\DiscountService::class);
        $this->app->bind(\App\Services\Auth\AuthServiceInterface::class, \App\Services\Auth\AuthService::class);
        //:end-bindings:
    }
}
