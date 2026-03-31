<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Formation;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::query()
            ->with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        return view('public.formations.index', compact('formations'));
    }

    public function show(string $slug)
    {
        $locale = app()->getLocale();
        $slugField = "slug_{$locale}";

        $formation = Formation::query()
            ->where($slugField, $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $formation->load(['category', 'trainingSessions' => function($query) {
            $query->where('status', 'upcoming')->orderBy('start_date');
        }]);

        return view('public.formations.show', compact('formation'));
    }
}
