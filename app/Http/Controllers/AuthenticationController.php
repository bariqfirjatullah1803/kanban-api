<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated = $credentials->safe()->only(['email', 'password']);

        if (!Auth::attempt($validated)) {
            return $this->_apiResponse(false, 401, [], 'Unauthorized');
        }

        $user = User::query()->where('email', $validated['email'])->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;

        return $this->_apiResponse(true, 200, [
            'user' => $user,
            'token' => $token
        ], 'Login successfully');
    }

    /**
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated = $validator->validated();

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $user['token'] = $user->createToken('authToken')->plainTextToken;

        return $this->_apiResponse(true, 201, $user, 'Registration successfully');
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return $this->_apiResponse(true, 200, [], 'Logout successfully');
    }
}
