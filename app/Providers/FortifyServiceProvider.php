<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyBaseLoginRequest;
use Laravel\Fortify\Http\Requests\RegisterRequest as FortifyBaseRegisterRequest;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\FortifyLoginRequest;
use App\Http\Requests\RegisterRequest;

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

        // メール認証誘導画面を表示する設定
        Fortify::verifyEmailView(function () {
            return view('verify');
        });

        // 登録・ログイン画面の設定
        Fortify::registerView(function () {
            return view('register');
        });

        Fortify::loginView(function () {
            return view('login');
        });


        $this->app->bind(FortifyBaseLoginRequest::class, FortifyLoginRequest::class);

        $this->app->bind(FortifyBaseRegisterRequest::class, RegisterRequest::class);

    }
}
