<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class TeacherAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if((Auth::guard('teacher')->check()))
        {
            return $next($request);
        }
        else
        {
            if($request->ajax()) {
                if($request->wantsJson()) {
                    return json_encode(array('auth' => 0));
                } else {
                    return 0;
                }
            } else {
                return redirect()->route("teacher.login");
            }
        }
    }
}
