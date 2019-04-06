<?php

namespace App\Http\Middleware;

use Closure;

class IsDataComplete
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
        if(auth()->user()->isDataComplete()) {
            return $next($request);
        }
        
        return redirect('home')->withStatus(__('Silahkan lengkapi data berikut terlebih dahulu'));
    }
}
