<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'receiver_id' => 'required|exists:users,id|different:' . auth()->id(),
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_id.different' => 'You cannot send an invitation to yourself.',
        ];
    }
}
