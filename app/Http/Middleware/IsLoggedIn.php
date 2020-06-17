<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsLoggedIn
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
        $header = $request->header('Authorization');
        if(!$header) {
            return response()->json(array('status' => 'error', 'message' => 'Missing token'));
        }
        $authorizations = explode(" ", $header);
        if(!isset($authorizations[1])) {
            return response()->json(array('status' => 'error', 'message' => 'Missing token'));
        }

        $user = User::where('api_token', $authorizations[1])->first();
        if(!$user) {
            return response()->json(array('status' => 'error', 'message' => 'Invalid token'));
        }

        Auth::setUser($user);
        return $next($request);
    }
}
