<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $user = $request->authenticate();
            // create token, for 7 days
            $tokenResult = $user->createToken($request->device_name ?? 'StudyPlanner', ["*"], now()->addDays(env('SANCTUM_TOKEN_LIFETIME')));
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
            $data['user'] = $user;
            return respondJson($data);
        } catch (\Exception $e) {
            if($e->status == 422) {
                return respondError($e->getMessage(), 422);
            }
            return respondError('Something went wrong ! ', 500);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            // Revoke the token that was used to authenticate the current request...
            if ($request->user()->currentAccessToken()) {
                $request->user()->currentAccessToken()->delete();
            }
            return respondSuccess('Logout Successful !');
        } catch (\Exception $e) {
            return respondError('Unauthenticated !', 401);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateToken(Request $request)
    {
        try {
            return respondSuccess('Authenticated', auth()->user());
        } catch (\Exception $e) {
            return respondError('Unauthenticated !', 401);
        }
    }
}
