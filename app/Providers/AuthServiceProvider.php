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
        Gate::define('accessPermission', function ($user,$module) {
           return $user->hasAccess($module,'access');
        });

        Gate::define('addPermission', function ($user,$module) {
            return $user->hasAccess($module,'add');
        });

        Gate::define('viewPermission', function ($user,$module) {
            return $user->hasAccess($module,'view');
        });

        Gate::define('statusPermission', function ($user,$module) {
            return $user->hasAccess($module,'status');
        });

        Gate::define('editPermission', function ($user,$module) {
            return $user->hasAccess($module,'edit');
        });

        Gate::define('deletePermission', function ($user,$module) {
            return $user->hasAccess($module,'delete');
        });
    }
}
