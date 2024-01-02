<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Schema;
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
        // Retrieve the GeneralSetting once and store it in a variable
        $generalSetting = GeneralSetting::find(1);

        // Check if the GeneralSetting was found before accessing its properties
        if ($generalSetting) {
            $adminLogo = $generalSetting->admin_logo ?? '';
            $faviconLogo = $generalSetting->favicon ?? '';

        }else {
            $adminLogo = null;
            $faviconLogo = null;
        }

        // Share the variables with views
        view()->share('adminLogo', $adminLogo);
        view()->share('faviconLogo', $faviconLogo);

        Schema::defaultStringLength(191);
    }
}
