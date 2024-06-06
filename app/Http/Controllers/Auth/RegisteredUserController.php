<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:191', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // create token, for 7 days
        $tokenResult = $request->user()->createToken($request->device_name ?? 'StudyPlanner', ["*"], now()->addDays(7));
        $data = [];
        $data['token'] = $tokenResult->plainTextToken;
        $data['token_name'] = $tokenResult->accessToken->name;
        $data['token_type'] = 'Bearer';
        $data['created_at'] =  Carbon::parse(
            $tokenResult->accessToken->created_at
        )->toDateTimeString();
        $data['expires_at'] =  Carbon::parse(
            $tokenResult->accessToken->expires_at
        )->toDateTimeString();
        $data['user'] = $request->user();
        return respondSuccess('Registration successful !', $data, 'data', 201);
    }
}
