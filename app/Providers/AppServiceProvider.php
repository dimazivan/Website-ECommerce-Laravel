<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env(key:'APP_ENV') !=='local') {
            URL::forceScheme(scheme:'https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Http\Request $request)
    {
        if (!empty(env('NGROK_URL')) && $request->server->has('HTTP_X_ORIGINAL_HOST')) {
            $this->app['url']->forceRootUrl(env('NGROK_URL'));
        }

        Paginator::defaultView('pagination::default');
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
