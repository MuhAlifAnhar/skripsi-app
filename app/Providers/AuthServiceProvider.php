<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $policies = [];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

    // semua
    Gate::define('semuaRole', function (User $user) {
        return in_array($user->role, ['owner', 'operator']);
    });

    // owner
    Gate::define('isOwner', function (User $user) {
        return $user->role === 'owner';
    });

    // operator
    Gate::define('isOperator', function (User $user) {
        return $user->role === 'operator';
    });
    }
}
