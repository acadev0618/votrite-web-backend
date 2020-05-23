<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class SetUserid
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
        // var_dump($request->all());
        // View::composer('*', function($view){
        //     $view->with('categories', $categories);
        // }
        $user_id = session('user_id');
        View::share('userid', $user_id);
        return $next($request);
    }
}
