<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $formations = Formation::where('status', 'published')->get();
        $posts = Post::where('status', 'published')->get();

        $content = view('public.sitemap', compact('formations', 'posts'))->render();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $content;

        return response($xml)
            ->header('Content-Type', 'text/xml');
    }
}
