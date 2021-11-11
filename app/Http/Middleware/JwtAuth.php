<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Jwt;
use Closure;
use App\User;
use Exception;

class JwtAuth
{
    private $jwt;

    public function __construct(Jwt $jwt)
    {
        $this->jwt = $jwt;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try {

            if ($token = $request->bearerToken()) {
                if (!$this->jwt->validate($token)) {
                    return response()->json(['message' => 'Token is not valid']);
                } else {
                    if (!User::where('remember_token', $token)->exists()) {
                        return response()->json(['message' => 'No user for this token']);
                    }
                }
            } else {
                return response()->json(['message' => 'Token is not provided']);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong']);
        }

        return $next($request);
    }
}
