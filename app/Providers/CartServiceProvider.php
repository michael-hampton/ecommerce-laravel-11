<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Cart\Cart;
use Illuminate\Auth\Events\Logout;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('cart', function (): \App\Services\Cart\Cart {
            return new Cart($this->app['session'], $this->app['events']);
        });

        $this->app['events']->listen(Logout::class, function (): void {
            if ($this->app['config']->get('cart.destroy_on_logout')) {
                $this->app->make(SessionManager::class)->forget('cart');
            }
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
