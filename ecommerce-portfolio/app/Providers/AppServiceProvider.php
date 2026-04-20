<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\CurrencyFormatter;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CurrencyFormatter::class);
    }

    public function boot(): void
    {
        // @currency(50000) → ฿500.00
        Blade::directive('currency', function (string $expression): string {
            return "<?php echo \App\Services\CurrencyFormatter::format((int) ({$expression})); ?>";
        });
    }
}
