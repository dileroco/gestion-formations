<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $locale = app()->getLocale();

        if (empty($query)) {
            return redirect()->back();
        }

        $formations = Formation::query()
            ->where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title_fr', 'like', "%{$query}%")
                  ->orWhere('title_en', 'like', "%{$query}%")
                  ->orWhere('description_fr', 'like', "%{$query}%")
                  ->orWhere('description_en', 'like', "%{$query}%");
            })
            ->get();

        $posts = Post::query()
            ->where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title_fr', 'like', "%{$query}%")
                  ->orWhere('title_en', 'like', "%{$query}%")
                  ->orWhere('content_fr', 'like', "%{$query}%")
                  ->orWhere('content_en', 'like', "%{$query}%");
            })
            ->get();

        return view('public.search', compact('formations', 'posts', 'query'));
    }
}
