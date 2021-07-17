<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use Auth;
use App\Models\EduProviderUsers;
use App\Models\EduTeachers;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // BOTH ARE WORKING
        // $authId = Auth::guard('provider')->id();
        // $data['userInfo'] = EduProviderUsers::where('valid', 1)->find($authId);
        // View::share($data);
        view()->composer(
            'provider.layouts.default',
            function ($view)
            {
                $authId = Auth::guard('provider')->id();
                $data['userInfo'] = EduProviderUsers::where('valid', 1)->find($authId);
                $view->with($data);
            }
        );
        view()->composer(
            'teacher.layouts.default',
            function ($view)
            {
                $authId = Auth::guard('teacher')->id();
                $data['userInfo'] = EduTeachers::where('valid', 1)->find($authId);
                $view->with($data);
            }
        );
        view()->composer(
            'layouts.default',
            function ($view)
            {
                $authId = Auth::id();
                $data['userInfo'] = User::find($authId);
                $view->with($data);
            }
        );
    }
}
