<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session()->has('user_id')) {
            return redirect->route('user.login');
        }

        $user= \App\Models\User::find(session('user_id'));

        if(!$user || $user->block) {
            session()->forget('user_id');
            return redirect()->route('user.login')
                ->with('error', 'Your account has been blocked.');
        }

        return $next($request);
    }
}
