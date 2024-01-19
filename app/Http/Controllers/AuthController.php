<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    // This method is responsible for handling the login request.
    public function login(LoginUserRequest $request)
    {
        // Extract the validated credentials from the request.
        $credentials = $request->validated();

        // Attempt to authenticate the user using the provided credentials.
        if (!Auth::attempt($credentials)) {
            // If the authentication attempt fails, return an error response.
            return $this->error('', 'Invalid credentials', 401);
        }

        // Retrieve the user record from the database based on the email address.
        $user = User::where('email', $credentials['email'])->first();

        // Return a success response with the user data and an API token.
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    // This method is responsible for handling the registration request.
    public function register(StoreUserRequest $request)
    {
        // Extract the validated data from the request.
        $validatedData = $request->validated();

        // Create a new user record in the database.
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Return a success response with the user data and an API token.
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    // This method is responsible for handling the logout request.
    public function logout()
    {
        // Delete the current user's API token.
        Auth::user()->currentAccessToken()->delete();

        // Return a success response.
        return $this->success('', 'User logged out successfully');
    }
}
