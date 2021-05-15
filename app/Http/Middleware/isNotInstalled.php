<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Artisan;

class isNotInstalled
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
            $is_installed = Artisan::call('migrate:status');
        } catch (\Throwable $th) {
            $is_installed = false;
        }

        try {
            $admin_exist = User::where('type', User::ADMIN_TYPE)->count() > 0;
        } catch (\Throwable $th) {
            $admin_exist = false;
        }

        if ($is_installed && $admin_exist) {
            return redirect('/');
        }

        return $next($request);
    }
}
