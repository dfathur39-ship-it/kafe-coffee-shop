<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            if (auth()->check() && auth()->user()->isCustomer()) {
                $view->with('cartCount', app(CartService::class)->count());
            }
        });

        View::composer('layouts.customer', function ($view) {
            $view->with('cartCount', app(CartService::class)->count());
        });
    }
}
