<?php

namespace App\Providers;

use App\Models\CompanySetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (str_starts_with($view->name(), 'admin.')) {
                return;
            }
            $settings = CompanySetting::all()->pluck('value', 'key');
            $view->with('settings', $settings);
        });
    }
}
