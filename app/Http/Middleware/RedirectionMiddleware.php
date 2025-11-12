<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Redirection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class RedirectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Forget previous session data
        Session::forget(['_previous']);

        $currentURL = URL::current();
        // Check if there's any redirection rule for this URL in the database
        $checkURL = Redirection::where('old_link', $currentURL)->orderBy('id', 'desc')->limit(1)->first();

        // If there's a redirection rule, perform the redirection
        if (!empty($checkURL)) {
            return redirect($checkURL->new_link, $checkURL->code);
        }

        // Continue processing the request if no redirection
        return $next($request);
    }
}