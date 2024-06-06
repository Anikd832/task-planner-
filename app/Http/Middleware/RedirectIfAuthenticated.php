<?php

namespace App\Http\Middleware;

use App\Models\Sanctum\PersonalAccessToken;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // laravel
        // $guards = empty($guards) ? [null] : $guards;
        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //         return redirect(RouteServiceProvider::HOME);
        //     }
        // }

        $token = $_COOKIE['studyplanner_access'] ?? null;
        if (!$token) {
            return $next($request);
        }
        $tokenResult = PersonalAccessToken::findToken($token);
        if (
            $tokenResult &&
            !$tokenResult->created_at->gt($tokenResult->expires_at) &&
            ($tokenResult->expires_at && !$tokenResult->expires_at->isPast())
        ) {
            if ($user = User::find($tokenResult->tokenable_id)) {
                return respondJson($user, 'loggedin');
            }
        }
        return $next($request);
    }
}
