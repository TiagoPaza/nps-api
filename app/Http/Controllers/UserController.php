<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Responses\UserCollectionResponse;
use App\Http\Responses\UserResponse;
use App\User;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param User $model
     * @return UserCollectionResponse|JsonResponse
     */
    public function index(Request $request, User $model)
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = $model->paginate($request->input('limit'))->appends($request->query());
        $users = $paginator->getCollection();

        return new UserCollectionResponse($users, $paginator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     * @param User $model
     * @return UserResponse|JsonResponse
     */
    public function store(UserCreateRequest $request, User $model)
    {
        $user = $model->create($request->except('role'));
        $role = Role::findByName($request->input('role'));
        $user->assignRole($role);

        return new UserResponse($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResponse|JsonResponse
     */
    public function show(User $user)
    {
        return new UserResponse($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return UserResponse|JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->except('role'));
        $user->syncRoles($request->only('role'));

        return new UserResponse($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $roles = $user->getRoleNames();

        foreach ($roles as $role) {
            $user->removeRole($role);
        }

        $user->delete();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @return JsonResponse
     */
    public function authenticated()
    {
        if (auth()->user()) {
            $data = [
                'type' => 'authenticated_user',
                'id' => auth()->user()->id,
                'attributes' => auth()->user(),
                'relationships' => [
                    'roles' => auth()->user()->getRoleNames()
                ]
            ];
        } else {
            if (request()->route()->getPrefix() === 'api/v1/en') {
                $code = 401;
                $title = 'Token not found.';
                $detail = 'You are disconnected because your token was expired or not exist. Please re-login!';
            } else {
                $code = 401;
                $title = 'Token não encontrado.';
                $detail = 'Você foi desconecado porque o seu token expirou e/ou não existe. Por favor, re-logue!';
            }

            $data = [
                'errors' => [
                    'code' => $code,
                    'title' => $title,
                    'detail' => $detail
                ]
            ];
        }

        return response()->json(['data' => $data], Response::HTTP_UNAUTHORIZED);
    }
}
