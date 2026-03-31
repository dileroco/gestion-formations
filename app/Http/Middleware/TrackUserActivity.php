<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && Schema::hasColumn('users', 'last_activity_at')) {
            $user->forceFill(['last_activity_at' => now()])->save();
        }

        return $next($request);
    }
}
