<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $title;
    protected $detail;

//    /**
//     * Create a new AuthController instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login']]);
//    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = auth()->attempt($input)) {
            if (request()->route()->getPrefix() === 'api/v1/en') {
                $this->title = 'Unauthorized.';
                $this->detail = 'Invalid email/password or not seted in your header "Content-Type: application/json"';
            } else {
                $this->title = 'Sem autorização.';
                $this->detail = 'O e-mail e/ou senha incorreto ou não foi setado o header "Content-Type: application/json"';
            }

            $errors = [
                'code' => 401,
                'title' => $this->title,
                'detail' => $this->detail
            ];

            return response()->json(['errors' => $errors], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($jwt_token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'data' => [
                'type' => 'token',
                'id' => auth()->user()->id,
                'attributes' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60
                ]
            ]
        ], Response::HTTP_CREATED);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            auth()->logout();

            if (request()->route()->getPrefix() === 'api/v1/en') {
                $this->title = 'Logged out.';
                $this->detail = 'Success! You are disconnected.';
            } else {
                $this->title = 'Desconectado.';
                $this->detail = 'Sucesso! Você foi desconectado.';
            }

            return response()->json([
                'data' => [
                    'type' => $this->title
                ],
                'attributes' => [
                    'description' => $this->detail
                ]
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'errors' => [
                    'code' => 500,
                    'title' => 'Error on disconnect.',
                    'description' => $exception->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
