<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;



class CacheFullResponse
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
        return $next($request);
    }

    /**
     * Cache the content of the response at the end of lifecycle
     * caches only 200 status responses
     * @param $request
     * @param $response
     */
    public function terminate($request, $response)
    {
        $key = 'response_' . Str::slug($request->fullUrl() . implode('.', $request->all()));
        if (!Cache::has($key) && $response->status() === '200') {
            Cache::put($key, $response->getContent(), 3600);
        }
    }
}
