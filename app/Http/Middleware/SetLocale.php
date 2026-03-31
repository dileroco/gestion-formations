<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $segment = $request->segment(1);
        $locale = in_array($segment, ['fr', 'en'], true)
            ? $segment
            : session('locale', config('app.locale', 'fr'));

        app()->setLocale($locale);
        session(['locale' => $locale]);

        return $next($request);
    }
}
