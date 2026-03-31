<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && ! $user->is_active) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors(['account' => 'Votre compte est desactive.']);
        }

        return $next($request);
    }
}
