<?php

namespace App\Http\Middleware\Routes;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Plan
{
    /*
     * Title of error
     */
    protected $title;

    /*
     * Detail of error
     */
    protected $detail;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->is('api/v1/en/plans') || $request->is('api/v1/plans')) {
            if ($request->isMethod('GET')) {
                if (!auth()->user()->can('retorna planos')) {
                    $errors = $this->respondWithError($request->url());

                    return response()->json(['errors' => $errors], Response::HTTP_FORBIDDEN);
                } else {
                    return $next($request);
                }
            } elseif ($request->isMethod('POST')) {
                if (!auth()->user()->can('insere plano')) {
                    $errors = $this->respondWithError($request->url());

                    return response()->json(['errors' => $errors], Response::HTTP_FORBIDDEN);
                } else {
                    return $next($request);
                }
            }
        }

        if ($request->is('api/v1/en/plans/*') || $request->is('api/v1/plans/*')) {
            if ($request->isMethod('GET')) {
                if (!auth()->user()->can('retorna plano')) {
                    $errors = $this->respondWithError($request->url());

                    return response()->json(['errors' => $errors], Response::HTTP_FORBIDDEN);
                } else {
                    return $next($request);
                }
            }

            if ($request->isMethod('PUT')) {
                if (!auth()->user()->can('altera plano')) {
                    $errors = $this->respondWithError($request->url());

                    return response()->json(['errors' => $errors], Response::HTTP_FORBIDDEN);
                } else {
                    return $next($request);
                }
            }

            if ($request->isMethod('DELETE')) {
                if (!auth()->user()->can('remove plano')) {
                    $errors = $this->respondWithError($request->url());

                    return response()->json(['errors' => $errors], Response::HTTP_FORBIDDEN);
                } else {
                    return $next($request);
                }
            }
        }

        if ($request->is('api/v1/en/plans/*/edit') || $request->is('api/v1/plans/*/edit')) {
            if (!auth()->user()->can('altera plano')) {
                $errors = $this->respondWithError($request->url());

                return response()->json(['errors' => $errors], Response::HTTP_FORBIDDEN);
            } else {
                return $next($request);
            }
        }
    }

    /**
     * Catch error and return response.
     *
     * @param string $url
     * @return mixed
     */
    protected function respondWithError($url)
    {
        if (strpos($url, '/en') !== false) {
            $this->title = 'Forbidden request!';
            $this->detail = 'Your user not have permission to request the URL: ' . $url;
        } else {
            $this->title = 'Requisição proibida!';
            $this->detail = 'O seu usuário não possui permissão para realizar requisições a URL: ' . $url;
        }
        return [
            'code' => 403,
            'title' => $this->title,
            'detail' => $this->detail
        ];
    }
}
