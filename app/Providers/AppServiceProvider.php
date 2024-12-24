<?php

namespace App\Providers;

use Doctrine\DBAL\Types\Type;
use Illuminate\Support\Facades\URL;
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
        // No need to force HTTPS in the register method, it should be done in boot
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force HTTPS in non-local environments
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        // Set file upload size limits
        ini_set('post_max_size', '50M');
        ini_set('upload_max_filesize', '50M');
        
        // Register 'timestamp' type with Doctrine if it hasn't been registered yet
        if (!Type::hasType('timestamp')) {
            // Use 'datetime' as a string instead of Types::DATETIME constant
            Type::addType('timestamp', Type::getType('datetime'));
        }
    }
}
