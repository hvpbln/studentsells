<?php

namespace App\Providers;

use App\Models\Wishlist;
use App\Policies\WishlistPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Wishlist::class => WishlistPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
