<?php
// app/Http/Controllers/InvitationController.php

namespace App\Http\Controllers;

use App\Http\Requests\SendInvitationRequest;
use App\Models\Invitation;
use App\Models\User;
use App\Services\InvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InvitationController extends Controller
{
    use AuthorizesRequests;
    
    private InvitationService $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

    public function index()
    {
        $user = Auth::user();
        
        $receivedInvitations = $user->receivedInvitations()
            ->with('sender')
            ->pending()
            ->latest()
            ->get();

        $sentInvitations = $user->sentInvitations()
            ->with('receiver')
            ->pending()
            ->latest()
            ->get();

        return view('invitations.index', compact('receivedInvitations', 'sentInvitations'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('invitations.create', compact('users'));
    }

    public function store(SendInvitationRequest $request)
    {
        try {
            $receiver = User::findOrFail($request->receiver_id);
            $this->invitationService->sendInvitation(Auth::user(), $receiver);

            return redirect()->route('invitations.index')
                ->with('success', 'Invitation sent successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function accept(Invitation $invitation)
    {
        $this->authorize('accept', $invitation);

        try {
            $this->invitationService->acceptInvitation($invitation);
            return redirect()->route('invitations.index')
                ->with('success', 'Invitation accepted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function decline(Invitation $invitation)
    {
        $this->authorize('decline', $invitation);

        try {
            $this->invitationService->declineInvitation($invitation);
            return redirect()->route('invitations.index')
                ->with('success', 'Invitation declined.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}