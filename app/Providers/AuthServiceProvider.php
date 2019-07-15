<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        // Gate::define('viewLarecipe', function($user, $documentation) {
        //     return TRUE;
        //     $doc_title = [
        //         'Profil (admin)',
        //         'Master data (admin)',
        //         'Pengaturan (admin)',
        //         'Lowongan kerja (admin)',
        //     ];

        //     foreach ($doc_title as $d) {
        //         if ($documentation->title == $d) {
        //             if ($user->isAdmin()) {
        //                 return false;
        //             } else {
        //                 return true;
        //             }
        //         }
        //     }

        //     return true;
        // });
    }
}
