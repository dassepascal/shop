<?php

namespace App\Providers;

use App\Models\Shop;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(app()->runningInConsole()) {
            return;
        }
        
        View::share('shop', Shop::firstOrFail());

        // Custom Blade Directives Helpers pour la lettre majuscule dans les traductions

        Blade::directive(name: 'langL', handler: function ($expression) {
            return "<?= transL({$expression}); ?>";
        });
    }
    }

