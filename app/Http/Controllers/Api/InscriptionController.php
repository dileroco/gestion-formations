<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InscriptionResource;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InscriptionController extends Controller
{
    public function index(Request $request)
    {
        $inscriptions = Inscription::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return InscriptionResource::collection($inscriptions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => ['required', 'exists:training_sessions,id'],
        ]);

        $inscription = Inscription::create([
            'user_id' => $request->user()->id,
            'session_id' => $validated['session_id'],
            'reference' => Str::upper(Str::random(10)),
            'status' => 'pending',
        ]);

        return new InscriptionResource($inscription);
    }
}
