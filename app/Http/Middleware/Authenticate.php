<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate
{
    protected $title;
    protected $detail;
    /**
     * The authentication guard factory instance.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param Auth $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            if (request()->route()->getPrefix() === 'api/v1/en') {
                $this->title = 'Unauthorized.';
                $this->detail = 'You are disconnected! Your token are expired or is invalid, please re-login to validade your account!';
            } else {
                $this->title = 'Sem autorização.';
                $this->detail = 'Você foi desconectado! O seu token expirou ou é inválido, por favor re-logue para validar a sua conta!';
            }

            return response()->json([
                'errors' => [
                    'code' => 401,
                    'title' => $this->title,
                    'detail' => $this->detail
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
