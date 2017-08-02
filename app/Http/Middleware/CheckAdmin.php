<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
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
        if (Auth::check()) {
            $user = Auth::user();

            if($user->email != 'talipdurmus1@gmail.com'){
                abort(403, 'Unauthorized action.');
            }

        }else {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
