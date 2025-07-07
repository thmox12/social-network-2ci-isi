<?php
// app/Policies/InvitationPolicy.php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;

class InvitationPolicy
{
    public function accept(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->receiver_id && $invitation->status === 'pending';
    }

    public function decline(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->receiver_id && $invitation->status === 'pending';
    }

    public function cancel(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->sender_id && $invitation->status === 'pending';
    }
}