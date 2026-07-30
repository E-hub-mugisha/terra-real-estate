<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * The locales Terra supports. Keep this in sync with the
     * <select>/lang-switcher options in the header partial.
     */
    protected array $supported = ['en', 'rw', 'fr'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale');

        if (! $locale || ! in_array($locale, $this->supported, true)) {
            $locale = config('app.fallback_locale', 'en');
        }

        App::setLocale($locale);

        return $next($request);
    }
}