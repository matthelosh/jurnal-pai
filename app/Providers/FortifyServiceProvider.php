<?php

namespace App\Providers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->username;

            return Limit::perMinute(1)->by($email.$request->ip());
        });

        // RateLimiter::for('two-factor', function (Request $request) {
        //     return Limit::perMinute(5)->by($request->session()->get('login.id'));
        // });
        Fortify::loginView(function() {
            return Inertia::render('Auth/Login')->withViewData(['pageTitle' => 'Login | Jurnal PAI Wagir', 'description' => 'Laman Login Jurnal Pembelajaran PAI Kecamatan Wagir']);
        });

        Fortify::authenticateUsing(function(Request $request) {
            $user = User::where('username', $request->username)->first();

            if($user ) {
                if(Hash::check($request->password, $user->password)) {
                    return $user;
                }
            } else {
                throw ValidationException::withMessages([
                    Fortify::username() => "User tidak ditemukan. Cek kembali Username Anda!"
                ]);
            }
        });
    }
}
