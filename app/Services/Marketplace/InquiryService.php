<?php

namespace App\Services\Marketplace;

use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Every inquiry from a listing page is stored (so it shows in the owner/agent room
 * and in admin monitoring) and, when possible, emailed to the listing contact.
 */
class InquiryService
{
    public function record(Model $listing, Request $request, ?Mailable $mail = null): Inquiry
    {
        $recipient = $listing->contactUser();

        $inquiry = Inquiry::create([
            'listable_type' => $listing->getMorphClass(),
            'listable_id' => $listing->getKey(),
            'sender_id' => $request->user()?->id,
            'recipient_id' => $recipient?->id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
            'status' => 'new',
        ]);

        if ($mail && $recipient?->email) {
            try {
                Mail::to($recipient->email)->send($mail);
            } catch (\Throwable $e) {
                // The inquiry is saved and visible in the room even if email fails.
                Log::warning('Inquiry email failed', ['inquiry' => $inquiry->id, 'error' => $e->getMessage()]);
            }
        }

        return $inquiry;
    }
}
