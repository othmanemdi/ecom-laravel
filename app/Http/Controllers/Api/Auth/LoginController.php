<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'access_token' => $user->createToken($request->device_name)->plainTextToken,
        ], Response::HTTP_CREATED);

        // return $user->createToken($request->device_name)->plainTextToken;
        // User::create(['email' => 'user@user.com', 'password' => bcrypt('user'), 'name' => 'user']);

        // $device    = substr($request->userAgent() ?? '', 0, 255);
        // $expiresAt = $request->remember ? null : now()->addMinutes(config('session.lifetime'));

        // return response()->json([
        //     'access_token' => $user->createToken($device, expiresAt: $expiresAt)->plainTextToken,
        // ], Response::HTTP_CREATED);

    }
}
