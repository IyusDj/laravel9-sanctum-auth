<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {   
        // Validation Form
        $validator = $request->validate([
            'email'     => ['required'],
            'password'  => ['required'],
        ]);

        
        if (auth()->attempt($validator)) {
            $user = auth()->user();

            return (new UserResource($user))->additional([
                'token' => $user->createToken('djToken')->plainTextToken,
            ]);
        }

        return response()->json([
            'message' => 'Your email & password does not match !',
        ], 401);
    }
}
