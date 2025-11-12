<?php

namespace App\Providers;

use App\Events\RouteRedirection;
use App\Models\Redirection;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $checkMediaURL = url()->current();
        $isNotValid   = false;
        if (env('APP_ENV') == 'production') {
            if (strpos($checkMediaURL, 'http://') !== false ) {
                $isNotValid = true;
                $checkMediaURL = str_replace('http://', 'https://', $checkMediaURL);
            }
            if (strpos($checkMediaURL, 'www.') == true ) {
                $isNotValid = true;
                $checkMediaURL = str_replace('https://www.', 'https://', $checkMediaURL);
            }
            if (strpos($checkMediaURL, 'www.') == true ) {
                $isNotValid = true;
                $checkMediaURL = str_replace('www.', 'https://', $checkMediaURL);
            }
            if (strpos($checkMediaURL, '/public/') !== false) {
                $isNotValid = true;
                $checkMediaURL = str_replace('/public/', '/', $checkMediaURL);
            }
            if (strpos($checkMediaURL, '/public') !== false) {
                $isNotValid = true;
                $checkMediaURL = str_replace('/public', '', $checkMediaURL);
            }
            if (strpos($checkMediaURL, '/allblogs') !== false) {
                $isNotValid = true;
                $checkMediaURL = str_replace('/allblogs', '/blogs', $checkMediaURL);
            }
            if (strpos($checkMediaURL, '/images/blogsImages') == true) {
                $isNotValid = true;
                $checkMediaURL = str_replace('/images/blogsImages', '/', $checkMediaURL);
            }

            if ($isNotValid) {
                return redirect($checkMediaURL)->send();
            }
        }

        if (Schema::hasTable('redirections')) {
            $currentURL = URL::current();
            $checkURL = Redirection::where('old_link', $currentURL)->orderBy('id', 'desc')->limit(1)->first();

            if ($checkURL) {
                // Redirect to the new link
                return  redirect($checkURL->new_link, $checkURL->code)->send();
            }
        }

        Paginator::useBootstrap();
    }
}