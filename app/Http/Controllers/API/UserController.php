<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(request $request, StoreUserRequest $storeUserRequest)
    {
        // Validate the request using the StoreUserRequest
        $validated = $storeUserRequest->validated();
        // Create a new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        //Create Token for the user
        $token = $user->createToken('api-token')->plainTextToken;
        // Return a response with the created user
        return (new UserResource($user))
            ->additional(['token' => $token])
            ->response()
            ->setStatusCode(201);
    }
    public function login(LoginUserRequest $loginUserRequest)
    {
        // Validate the request using the LoginUserRequest
        $validated = $loginUserRequest->validated();

        // Check if the user exists and the password is correct
        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create a token for the user
        $token = $user->createToken('api-token')->plainTextToken;

        // Return a response with the user and token
        return (new UserResource($user))
            ->additional(['token' => $token])
            ->response()
            ->setStatusCode(200);
    }
    public function logout(Request $request)
    {
        // Revoke the user's token
        $request->user()->currentAccessToken()->delete();

        // Return a response indicating successful logout
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
    public function profile(Request $request)
    {
        // Return the authenticated user's information
        return response()->json(new UserResource($request->user()), 200);
    }






}
