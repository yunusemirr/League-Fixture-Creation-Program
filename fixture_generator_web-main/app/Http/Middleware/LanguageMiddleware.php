<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = 'en';

        if($request->is('api/*')){
            if($request->user()){
                $locale = $request->user()->language ?? 'en';
            }
            elseif($request->has('lng')){
                $locale = $request->get('lng', 'en');
            }
            app()->setLocale($locale);
            $response = $next($request);
            $response->headers->set('x-hd-language', $locale);

            return $response;
        }

        //get locale from session if exists
        if (session()->has('locale')) {
            $locale = session()->get('locale');
        } else {
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2) ?? 'en';
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);
        $response = $next($request);
        $response->headers->set('x-hd-language', $locale);

        return $response;
    }
}
