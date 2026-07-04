<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LegacyAuthenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            if (app()->environment(['local', 'testing'])) {
                session([
                    'user_id' => 1,
                    'user_name' => 'Administrator',
                    'user_role' => 'admin',
                ]);
            } else {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
