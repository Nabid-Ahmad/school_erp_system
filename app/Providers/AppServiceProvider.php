<?php

namespace App\Providers;

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
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        if (!app()->runningInConsole()) {
            \Illuminate\Support\Facades\View::share('schoolSettings', \App\Models\Setting::all()->pluck('value', 'key'));
        }

        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->role === 'admin' ? true : null;
        });
    }
}
