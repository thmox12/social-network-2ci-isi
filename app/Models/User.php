<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function sentNotifications()
    {
        return $this->hasMany(Notification::class, 'from_user_id');
    }

    public function sentInvitations()
    {
        return $this->hasMany(Invitation::class, 'sender_id');
    }

    public function receivedInvitations()
    {
        return $this->hasMany(Invitation::class, 'receiver_id');
    }

    public function connections()
    {
        return $this->belongsToMany(User::class, 'user_connections', 'user_id', 'connected_user_id')
                    ->withTimestamps();
    }

    public function connectedBy()
    {
        return $this->belongsToMany(User::class, 'user_connections', 'connected_user_id', 'user_id')
                    ->withTimestamps();
    }

    public function getAllConnections()
    {
        return $this->connections->merge($this->connectedBy);
    }

    public function isConnectedTo(User $user)
    {
        return $this->connections->contains($user) || $this->connectedBy->contains($user);
    }

    public function hasInvitationFrom(User $user)
    {
        return $this->receivedInvitations()
                    ->where('sender_id', $user->id)
                    ->where('status', 'pending')
                    ->exists();
    }

    public function hasSentInvitationTo(User $user)
    {
        return $this->sentInvitations()
                    ->where('receiver_id', $user->id)
                    ->where('status', 'pending')
                    ->exists();
    }
}
