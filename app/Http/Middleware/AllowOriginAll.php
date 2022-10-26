<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowOriginAll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $response = $next($request);
        $response->header("Access-Control-Allow-Origin", "*");
        $response->header("Content-Type", "application/json");
        $response->header("Access-Control-Allow-Headers", "content-type");
        return $response;
    }
}
