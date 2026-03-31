<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInscriptionRequest;
use App\Http\Requests\Admin\UpdateInscriptionRequest;
use App\Models\Inscription;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::with(['user', 'trainingSession.formation'])->latest()->paginate(10);
        return view('admin.inscriptions.index', compact('inscriptions'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $sessions = TrainingSession::with('formation')->get();
        return view('admin.inscriptions.create', compact('users', 'sessions'));
    }

    public function store(StoreInscriptionRequest $request)
    {
        $data = $request->validated();
        $data['reference'] = strtoupper(Str::random(10));
        
        if ($data['status'] === 'confirmed') {
            $data['confirmed_at'] = now();
        }

        Inscription::create($data);

        return redirect()->route('admin.inscriptions.index')->with('status', 'Inscription créée.');
    }

    public function show(Inscription $inscription)
    {
        $inscription->load(['user', 'trainingSession.formation']);
        return view('admin.inscriptions.show', compact('inscription'));
    }

    public function edit(Inscription $inscription)
    {
        $inscription->load(['user', 'trainingSession.formation']);
        // Form only updates status/grade/note usually for edit, but let's pass all just in case
        return view('admin.inscriptions.edit', compact('inscription'));
    }

    public function update(UpdateInscriptionRequest $request, Inscription $inscription)
    {
        $data = $request->validated();
        
        if ($data['status'] === 'confirmed' && $inscription->status->value !== 'confirmed') {
            $data['confirmed_at'] = now();
        } elseif ($data['status'] === 'cancelled' && $inscription->status->value !== 'cancelled') {
            $data['cancelled_at'] = now();
        }

        $inscription->update($data);

        return redirect()->route('admin.inscriptions.index')->with('status', 'Inscription mise à jour.');
    }

    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return redirect()->route('admin.inscriptions.index')->with('status', 'Inscription supprimée.');
    }

    public function updateStatus(Request $request, Inscription $inscription)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $status = $request->status;
        
        $data = ['status' => $status];
        if ($status === 'confirmed') {
            $data['confirmed_at'] = now();
        } elseif ($status === 'cancelled') {
            $data['cancelled_at'] = now();
        }

        $inscription->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Status updated',
                'status' => $status,
                'status_label' => $inscription->status->label() ?? $status
            ]);
        }

        return redirect()->back()->with('status', 'Statut mis à jour.');
    }
}
