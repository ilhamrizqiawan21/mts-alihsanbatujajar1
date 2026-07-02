<?php

namespace App\Providers;

use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Schema::defaultStringLength(191);
        Model::preventLazyLoading(app()->isLocal());

        // Register legacy auth middleware alias for simple session-based auth
        $router = $this->app->make('router');
        $router->aliasMiddleware('legacy.auth', \App\Http\Middleware\LegacyAuthenticate::class);

        View::composer('*', function ($view): void {
            try {
                $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();
            } catch (\Throwable) {
                $activeYear = null;
            }

            $view->with('activeYear', $activeYear);
        });
    }
}
