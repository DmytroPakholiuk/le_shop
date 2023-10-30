<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Goods;
use App\Models\Passport\Client;
use App\Policies\GoodsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Goods::class => GoodsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::useClientModel(Client::class);

//        Passport::routes(function ($router) {
//            $router->forAuthorization();
//            $router->forAccessTokens();
//            $router->forTransientTokens();
//        });
//        Passport::tokensExpireIn(now()->addMinutes(5));
//        Passport::refreshTokensExpireIn(now()->addDays(10));
        Passport::tokensExpireIn(Carbon::now()->addDays(7));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(14));
    }
}
