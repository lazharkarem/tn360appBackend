<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // Define your policy mappings here.
        // For example:
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Register Passport routes if they are not cached.
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

        // Optionally, you can configure Passport here
        // For example, to enable Passport's PKCE support:
        // Passport::enableImplicitGrant();
        
        // Or set the Passport token's expiration time:
        // Passport::tokensExpireIn(now()->addDays(15));
    }
}
