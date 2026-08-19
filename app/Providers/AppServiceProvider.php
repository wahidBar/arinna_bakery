<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\LoginResponse;

class AppServiceProvider extends ServiceProvider
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
        $this->configureDefaults();
        $this->configureLoginRedirect();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Override Fortify LoginResponse untuk redirect berbasis role.
     */
    protected function configureLoginRedirect(): void
    {
        $this->app->singleton(LoginResponse::class, fn () => new class implements LoginResponse
        {
            public function toResponse($request): mixed
            {
                $user = $request->user();

                if ($user && $user->role === 'admin') {
                    // Force full page load — admin dashboard adalah Blade view (bukan Inertia)
                    return Inertia::location(route('admin.dashboard'));
                }

                // Force full page load ke home (juga Blade view)
                return Inertia::location(url('/'));
            }
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
