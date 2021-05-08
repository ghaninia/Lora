<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(\App\Repositories\Discount\DiscountRepositoryInterface::class, \App\Repositories\Discount\DiscountRepository::class);
        $this->app->bind(\App\Repositories\Option\OptionRepositoryInterface::class, \App\Repositories\Option\OptionRepository::class);
        $this->app->bind(\App\Repositories\Payment\PaymentRepositoryInterface::class, \App\Repositories\Payment\PaymentRepository::class);
        $this->app->bind(\App\Repositories\Permission\PermissionRepositoryInterface::class, \App\Repositories\Permission\PermissionRepository::class);
        $this->app->bind(\App\Repositories\Role\RoleRepositoryInterface::class, \App\Repositories\Role\RoleRepository::class);
        $this->app->bind(\App\Repositories\Ticket\TicketRepositoryInterface::class, \App\Repositories\Ticket\TicketRepository::class);
        $this->app->bind(\App\Repositories\Transaction\TransactionRepositoryInterface::class, \App\Repositories\Transaction\TransactionRepository::class);
        $this->app->bind(\App\Repositories\User\UserRepositoryInterface::class, \App\Repositories\User\UserRepository::class);
        //:end-bindings:
    }
}
