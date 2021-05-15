<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Artisan;

class isInstalled
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
        try {
            $admin_not_exist = User::where('type', User::ADMIN_TYPE)->count() <= 0;
        } catch (\Throwable $th) {
            $admin_not_exist = true;
        }

        if ($admin_not_exist) {
            return redirect()->route('setup.index');
        }

        return $next($request);
    }
}
