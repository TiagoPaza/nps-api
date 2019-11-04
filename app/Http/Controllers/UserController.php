<?php

namespace App\Http\Controllers;

use App\Exceptions\InputValidationException;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Responses\UserCollectionResponse;
use App\Http\Responses\UserResponse;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
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
     * @throws InputValidationException
     */
    public function store(UserCreateRequest $request, User $model)
    {
        if ($request->input('document_type')) {
            $data = json_decode(json_encode($request->all()), true);
            $this->validatePerson($request->input('document_type'), $data);
        }

        $data = json_decode(json_encode($request->all()), true);
        $this->validateRole($request->input('role'), $data);

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
        $user->syncRoles($request->input('role'));

        if ($request->input('role')) {
            $verifyLogist = Shopkeeper::where('id_user', $user->id)->first();
            $verifyAgent = Agent::where('id_user', $user->id)->first();
            $verifySeller = ShopkeeperSeller::where('id_seller', $user->id)->first();

            if (isset($verifyLogist)) {
                $verifyLogist->fill(['discount_registration' => $request->input('discount_registration'), 'discount_bonus' => $request->input('discount_bonus'), 'limit_credit' => $request->input('limit_credit'), 'id_user' => $user->id])->save();
            }

            if (isset($verifyAgent)) {
                $verifyAgent->fill(['monthly_goal' => $request->input('monthly_goal'), 'id_shopkeeper' => $request->input('id_shopkeeper'), 'id_seller' => $user->id])->save();
            }

            if (isset($verifySeller)) {
                $verifySeller->fill(['cellphone' => $request->input('cellphone'), 'commission' => $request->input('commission'), 'id_user' => $user->id])->save();
            }
        }

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

        return response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function authenticated()
    {
        if (auth()->user()) {
            $data = ['type' => 'authenticated_user', 'id' => auth()->user()->id, 'attributes' => auth()->user(), 'relationships' => ['roles' => auth()->user()->getRoleNames()]];
        } else {
            if (request()->route()->getPrefix() === 'api/v1/en') {
                $title = 'Token not found.';
                $detail = 'You are disconnected because your token was expired or not exist. Please re-login!';
            } else {
                $title = 'Token não encontrado.';
                $detail = 'Você foi desconecado porque o seu token expirou e/ou não existe. Por favor, re-logue!';
            }

            $data = ['errors' => ['code' => Response::HTTP_UNAUTHORIZED, 'title' => $title, 'detail' => $detail]];
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Validate role to create/update user
     *
     * @param string $role
     * @param array $data
     * @return InputValidationException|void
     * @throws InputValidationException
     */
    public function validateRole(string $role, array $data)
    {
        if ($role == 'Cliente - B2C') {
            $validator = Validator::make($data, ['discount_registration' => 'required|regex:/^\d+(\.\d{1,2})?$/', 'discount_bonus' => 'required|regex:/^\d+(\.\d{1,2})?$/', 'limit_credit' => 'required|regex:/^\d+(\.\d{1,2})?$/',]);

            if ($validator->fails()) {
                throw new InputValidationException($validator->errors()->getMessages());
            }
        }

        if ($role == 'Cliente - B2B') {
            $validator = Validator::make($data, ['monthly_goal' => 'required|regex:/^\d+(\.\d{1,2})?$/',]);

            if ($validator->fails()) {
                throw new InputValidationException($validator->errors()->getMessages());
            }
        }

        if ($role == 'Administrador') {
            $validator = Validator::make($data, ['cellphone' => 'required|string', 'commission' => 'required|integer',]);

            if ($validator->fails()) {
                throw new InputValidationException($validator->errors()->getMessages());
            }
        }

        if ($role == 'Desenvolvedor') {
            $validator = Validator::make($data, ['cellphone' => 'required|string', 'commission' => 'required|integer',]);

            if ($validator->fails()) {
                throw new InputValidationException($validator->errors()->getMessages());
            }
        }
    }

    /**
     * Validate role to create/update user
     *
     * @param string $document_type
     * @param array $data
     * @return InputValidationException|void
     * @throws InputValidationException
     */
    public function validatePerson(string $document_type, array $data)
    {
        if ($document_type == 'CNPJ') {
            $validator = Validator::make($data, ['social_reason' => 'required|string|min:3|max:191', 'fantasy_name' => 'required|string|min:3|max:191', 'state_registration' => 'required|string|min:3|max:191']);

            if ($validator->fails()) {
                throw new InputValidationException($validator->errors()->getMessages());
            }
        }

        if ($document_type == 'CPF') {
            $validator = Validator::make($data, ['first_name' => 'required|string|min:3|max:191', 'second_name' => 'required|string|min:3|max:191']);

            if ($validator->fails()) {
                throw new InputValidationException($validator->errors()->getMessages());
            }
        }
    }
//    /**
//     * @param User $model
//     * @param int $user
//     * @param Request $request
//     * @param ImageRepository $imageRepository
//     * @return JsonResponse
//     * @throws InputValidationException
//     */
//    public function postPhoto(User $model, int $user, Request $request, ImageRepository $imageRepository)
//    {
//        $validator = Validator::make($request->all(), ['photo' => 'image|max:8192|mimes:jpeg,png']);
//
//        if ($validator->fails()) {
//            throw new InputValidationException($validator->errors()->getMessages());
//        }
//
//        $user = $model->where('id', $user)->first();
//
//        if ($request->hasFile('photo')) {
//            $photo = $imageRepository->savePhoto($request->file('photo'), $user->id, 'users', 500);
//            $user->fill(['photo' => $photo])->save();
//        }
//
//        return response()->json(['data' => null], Response::HTTP_OK);
//    }
}

