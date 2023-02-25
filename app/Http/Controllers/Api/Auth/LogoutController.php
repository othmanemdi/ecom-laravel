<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    public function __invoke()
    {
        $user = User::where('id', auth()->id())->first(); // REMOVED THIS LINE
        // $user = Auth::user(); // ADDED THIS LINE
        if ($user) {
            $user->tokens()->delete();
        }
        return response()->noContent(); // 204
        return response()->json(['message' => "U'r message"], Response::HTTP_NO_CONTENT);
    }
}
