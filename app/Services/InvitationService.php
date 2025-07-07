<?php
// app/Services/InvitationService.php

namespace App\Services;

use App\Models\Invitation;
use App\Models\User;
use App\Models\UserConnection;
use Exception;
use Illuminate\Support\Facades\DB;

class InvitationService
{
    public function sendInvitation(User $sender, User $receiver): Invitation
    {
        if ($sender->id === $receiver->id) {
            throw new Exception("You cannot send an invitation to yourself.");
        }

        if ($sender->isConnectedTo($receiver)) {
            throw new Exception("You are already connected to this user.");
        }

        if ($sender->hasSentInvitationTo($receiver) || $receiver->hasSentInvitationTo($sender)) {
            throw new Exception("An invitation already exists between you and this user.");
        }

        return Invitation::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);
    }

    public function acceptInvitation(Invitation $invitation): void
    {
        DB::transaction(function () use ($invitation) {
            $invitation->update(['status' => 'accepted']);

            // Create mutual connections
            UserConnection::create([
                'user_id' => $invitation->sender_id,
                'connected_user_id' => $invitation->receiver_id,
            ]);

            UserConnection::create([
                'user_id' => $invitation->receiver_id,
                'connected_user_id' => $invitation->sender_id,
            ]);
        });
    }

    public function declineInvitation(Invitation $invitation): void
    {
        $invitation->update(['status' => 'declined']);
    }
}