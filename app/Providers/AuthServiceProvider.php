<?php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use App\Models\Invitation;
use App\Models\Post;
use App\Policies\InvitationPolicy;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Post::class => PostPolicy::class,
        Invitation::class => InvitationPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}