<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use OwenIt\Auditing\Models\Audit;
use App\Observers\AuditObserver;
use Illuminate\Support\Facades\Gate;

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
        Audit::observe(AuditObserver::class);
        Blade::component('components.input.text-area', 'text-area');
        Gate::before(function ($user, $ability) {
            return $user->hasRole('SUPERADMIN') ? true : null;
        });
    }
}
