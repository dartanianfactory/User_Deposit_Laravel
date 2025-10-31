<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Exceptions\User\UserNotFoundException;

class ApiAuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $validData = $request->validated();

            if (!Auth::attempt($validData)) {
                $this->noContent();
            }

            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                throw new UserNotFoundException();
            }

            $user->tokens()->delete();

            $tokenName = $request->email . '___' . $request->device_name;
            $token = $user->createToken($tokenName)->plainTextToken;

            return $this->success([
                'user' => $user,
                'token' => $token
            ], 'Вы вошли в аккаунт');
        } catch (\Exception $error) {
            return $this->conflict($error, $error->getMessage());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->success([], 'Вы вышли из аккаунта');
        } catch (\Exception $error) {
            return $this->conflict($error, $error->getMessage());
        }
    }
}