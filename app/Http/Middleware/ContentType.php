<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $allowedContentType)
    {
        $header = $request->header('Content-type');
        if ($header == $allowedContentType) {
            return $next($request);
        }
        return response([
            "error" => "invalid content type only {$allowedContentType} is supported"
        ],400);
    }
}
