<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsWriter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if($user && ($user->role === "admin" || $user->role === "writer")) {
            return $next($request);
        }
        return response()->json(array('status' => 'error', 'message' => "You don't have permission to do this"));
    }
}
