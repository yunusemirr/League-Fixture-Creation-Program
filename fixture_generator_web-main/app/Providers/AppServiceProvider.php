<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('money', function ($amount) {
            return "<?php echo number_format($amount, 2, ',', '.'); ?>";
        });

        Route::macro('fallbackRoute', function ($name, $fallback) {
            try {
                return route($name);
            } catch (RouteNotFoundException $e) {
                return Redirect::to($fallback);
            }
        });
    }
}
