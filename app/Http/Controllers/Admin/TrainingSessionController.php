<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTrainingSessionRequest;
use App\Http\Requests\Admin\UpdateTrainingSessionRequest;
use App\Models\Formation;
use App\Models\TrainingSession;
use App\Models\User;

class TrainingSessionController extends Controller
{
    public function index()
    {
        $query = TrainingSession::query()->with(['formation', 'trainer']);

        if (auth()->user()?->hasRole('Formateur')) {
            $query->where('trainer_id', auth()->id());
        }

        $sessions = $query->latest()->paginate(10);

        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $formations = Formation::query()->orderBy('title_fr')->get();
        $trainers = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'Formateur');
        })->get();

        if ($trainers->isEmpty()) {
            $trainers = User::query()->orderBy('name')->get();
        }

        return view('admin.sessions.create', compact('formations', 'trainers'));
    }

    public function store(StoreTrainingSessionRequest $request)
    {
        $data = $request->validated();

        if (auth()->user()->hasRole('Formateur')) {
            $data['trainer_id'] = auth()->id();
        }

        TrainingSession::create($data);

        return redirect()
            ->route('admin.sessions.index')
            ->with('status', 'Session créée avec succès.');
    }

    public function show(TrainingSession $session)
    {
        $this->authorizeTrainer($session);
        $session->load(['formation', 'trainer']);

        return view('admin.sessions.show', compact('session'));
    }

    public function edit(TrainingSession $session)
    {
        $this->authorizeTrainer($session);
        $formations = Formation::query()->orderBy('title_fr')->get();
        $trainers = User::role('Formateur')->orderBy('name')->get();

        if ($trainers->isEmpty()) {
            $trainers = User::query()->orderBy('name')->get();
        }

        return view('admin.sessions.edit', compact('session', 'formations', 'trainers'));
    }

    public function update(UpdateTrainingSessionRequest $request, TrainingSession $session)
    {
        $this->authorizeTrainer($session);
        $data = $request->validated();

        if (auth()->user()->hasRole('Formateur')) {
            unset($data['trainer_id']);
        }

        $session->update($data);

        return redirect()
            ->route('admin.sessions.index')
            ->with('status', 'Session mise à jour.');
    }

    public function destroy(TrainingSession $session)
    {
        $this->authorizeTrainer($session);
        $session->delete();

        return redirect()
            ->route('admin.sessions.index')
            ->with('status', 'Session supprimée.');
    }

    protected function authorizeTrainer(TrainingSession $session)
    {
        if (auth()->user()->hasRole('Formateur') && $session->trainer_id !== auth()->id()) {
            abort(403);
        }
    }
}
