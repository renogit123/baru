<?php

namespace App\Providers;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\Blade;
use App\View\Components\AdminLayout;
use App\View\Components\UserLayout;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


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
        Blade::component('admin-layout', AdminLayout::class);
        Blade::component('user-layout', UserLayout::class);
        View::composer('auth.register', function ($view) {
            $view->with('kelurahans', Kelurahan::with('kecamatan.kabupatenKota.provinsi')->get());
        });
    }
}
