<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->with(['category', 'author'])
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(10);

        return view('public.blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $locale = app()->getLocale();
        $slugField = "slug_{$locale}";

        $post = Post::query()
            ->where($slugField, $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.blog.show', compact('post'));
    }
}
