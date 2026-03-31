<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse
    {
        $contactMessage = ContactMessage::create($request->validated());

        // Notify Admins
        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->send(new ContactMessageMail($contactMessage));

        return response()->json([
            'message' => 'Contact message sent successfully',
            'data' => $contactMessage
        ], 201);
    }
}
