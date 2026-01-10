<?php

namespace Mralston\TailPdf;

use Illuminate\Support\ServiceProvider;
use Mralston\TailPdf\Services\TailPdfService;

class TailPdfServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('tailpdf.php'),
            ], 'tailpdf-config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'tailpdf');

        $this->app->singleton(TailPdfService::class, function ($app) {
            return new TailPdfService(
                // Config here
            );
        });
    }
}
