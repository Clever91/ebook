<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money_format', function ($amount, $mod = 0, $cur = false) {
            if ($cur !== false)
                return "<?php echo number_format($amount, $mod).' '.$cur ?>";
            return "<?php echo number_format($amount, $mod) ?>";
        });
    }
}
