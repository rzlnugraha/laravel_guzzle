<?php

namespace App\Http\Middleware;

use Closure, Session;

class ApiIfAuthenticate
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
        if (! session('authenticate')) {
            Session::flash('error','Harus login');
            return redirect(route('login'));
        }
        return $next($request);
    }
}
