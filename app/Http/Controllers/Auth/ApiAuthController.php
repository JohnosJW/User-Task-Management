<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiAuthController
 * @package App\Http\Controllers\Auth
 */
class ApiAuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        /** @var  $validatedData */
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        /** @var  $user */
        $user = User::create($validatedData);

        /** @var  $accessToken */
        $accessToken = $user->createToken('authToken')->accessToken;

        return $this->successResponse([
            'access_token' => $accessToken
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        /** @var  $loginData */
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($loginData)) {
            return $this->errorResponse(['message' => 'Invalid credentials']);
        }

        /** @var  $accessToken */
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return $this->successResponse([
            'user' => auth()->user(),
            'access_token' => $accessToken
        ]);
    }
}
