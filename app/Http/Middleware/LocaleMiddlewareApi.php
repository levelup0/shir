<?php

namespace App\Http\Middleware;

use Closure;
use App;
use App\Models\Language;

class LocaleMiddlewareApi
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
        /*if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }*/
        $lang_id = $request->input('lang_id');

        if(is_null($lang_id)){
            app()->setLocale(config('app.locale'));
            return $next($request);
        }

        $language = App\Models\Language::find($lang_id);

        if ($language != null) {
            app()->setLocale($language->name);
            return $next($request);
        }

        app()->setLocale(config('app.locale'));

        return $next($request);
    }
}
