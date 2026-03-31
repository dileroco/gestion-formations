<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $featuredFormations = Formation::query()
            ->with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        $recentPosts = Post::query()
            ->with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('public.home', compact('featuredFormations', 'recentPosts'));
    }
}
