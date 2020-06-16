<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = "en";
        if ($request->locale)
            $lang = $request->locale;

        if (array_search($lang, config('translatable.locales')) === false) {
            return redirect('/');
        }

        App::setLocale($lang);

        return $next($request);
    }
}
