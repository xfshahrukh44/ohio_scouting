<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
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

        // Admin
        Gate::define('isAdmin', function($user)
        {
            return $user->type === 'Admin';
        });
        
        // Realtor
        Gate::define('isRealtor', function($user)
        {
            return $user->type === 'Realtor';
        });

        // Cleaner
        Gate::define('isCleaner', function($user)
        {
            return $user->type === 'Cleaner';
        });

        // Guest
        Gate::define('isGuest', function($user)
        {
            return $user->type === 'Guest';
        });
    }
}
