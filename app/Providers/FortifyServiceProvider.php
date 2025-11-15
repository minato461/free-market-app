<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use Laravel\Fortify\Http\Requests\RegisterRequest as FortifyRegisterRequest; // 登録リクエストをインポート

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest; // カスタム登録リクエストをインポート

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(5)->by($email . $request->ip());
        });

        Fortify::registerView(function () {
            return view('register');
        });

        Fortify::loginView(function () {
            return view('login');
        });

        $this->app->bind(FortifyLoginRequest::class, LoginRequest::class);

        $this->app->bind(FortifyRegisterRequest::class, RegisterRequest::class);
    }
}
