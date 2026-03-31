<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('public.contact');
    }

    public function store(StoreContactRequest $request)
    {
        $contactMessage = ContactMessage::create($request->validated());

        // Notify Admins
        $adminEmail = config('mail.from.address'); // Or specific admin user
        Mail::to($adminEmail)->send(new ContactMessageMail($contactMessage));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => __('Your message has been sent successfully!'),
            ]);
        }

        return redirect()->back()->with('status', __('Your message has been sent successfully!'));
    }
}
