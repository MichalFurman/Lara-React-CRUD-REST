<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Services\AuthService;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $service = null;

    function __construct(AuthService $service) {
        $this->service = $service;
    }

    public function handle($request, Closure $next) {
        $result = $this->service->authJWToken($request);
        if ($result['code'] === 200) return $next($request);
        return  response()->json(['message' => $result['message']],$result['code']);
    }
}
