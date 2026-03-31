<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'users_count' => User::count(),
            'formations_count' => $user->hasRole('Formateur') 
                ? Formation::where('user_id', $user->id)->count() 
                : Formation::count(),
            'sessions_count' => $user->hasRole('Formateur') 
                ? TrainingSession::where('trainer_id', $user->id)->count() 
                : TrainingSession::count(),
            'pending_inscriptions' => Inscription::where('status', 'pending')
                ->when($user->hasRole('Formateur'), function($query) use ($user) {
                    $query->whereHas('trainingSession', function($q) use ($user) {
                        $q->where('trainer_id', $user->id);
                    });
                })->count(),
        ];

        // Recent Inscriptions
        $recentInscriptions = Inscription::with(['user', 'trainingSession.formation'])
            ->when($user->hasRole('Formateur'), function($query) use ($user) {
                $query->whereHas('trainingSession', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                });
            })
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentInscriptions'));
    }
}
