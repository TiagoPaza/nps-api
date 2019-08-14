<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    protected $title;
    protected $detail;

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

        if (!$jwt_token = JWTAuth::attempt($input)) {
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

            return response()->json(['errors' => $errors], 401);
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
        ], 201);
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
            JWTAuth::invalidate($request->token);

            return response()->json([
                'data' => [
                    'type' => 'logout'
                ],
                'attributes' => [
                    'description' => 'User logged out successfully!'
                ]
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'errors' => [
                    'code' => 500,
                    'title' => 'Disconnected.',
                    'description' => 'Sorry, the user cannot be logged out!'
                ]
            ], 500);
        }
    }
}
