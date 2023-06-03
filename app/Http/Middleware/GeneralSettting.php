<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\ApiHandler;
use App\Models\Language;
use Closure;
use Illuminate\Http\Request;

class GeneralSettting
{
    /**
     * @var ApiHandler
     */

    private $apiHandler;
    public function __construct(ApiHandler $apiHandler)
    {
        $this->apiHandler = $apiHandler;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->header('x-language', 'en');
        $token = $request->header('x-token', null);
        if ($language = Language::where('language_slug', $lang)->first()) {
            app()->setLocale($language->slug);
        } else {
            app()->setLocale('en');
        }

        if ($token != null) {
            if ($token == env('APP_TOKEN')) {
                return $next($request);
            }
        }
        return $this->apiHandler->getResponse(null, 'Unauthorized', 'error');
    }
}
