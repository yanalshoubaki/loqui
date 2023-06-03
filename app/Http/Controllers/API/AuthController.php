<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use App\Traits\UserOauthTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiHandler
{
    use UserOauthTrait;
    /**
     * Sign in request
     *
     * @param SignInRequest $request
     * @return JsonResponse
     */
    public function signInRequest(SignInRequest $request): JsonResponse
    {
        try {
            $credential = $request->getCredential();
            $remember = $request->getRemember() || false;
            if (Auth::attempt($credential, $remember)) {
                /** @var \App\Models\User $user */
                $user = Auth::user();

                $token = $this->getAccessToken([
                    'username' =>  $credential['email'],
                    'password' =>  $credential['password'],
                    'grant_type' => 'password',
                    'client_id' => env('PASSPORT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                    'scope' => '*'
                ]);

                $data = [
                    'user' => $user,
                    'token' => $token
                ];

                return $this->getResponse(
                    $data,
                    __("custom.login success"),
                    'success'
                );
            } else {

                return $this->getResponse(
                    null,
                    __("custom.login failed"),
                    'failed'
                );
            }
        } catch (\Throwable $th) {
            return $this->getResponse(
                null,
                $th->getMessage(),
                'failed'
            );
        }
    }

    public function signUpRequest(SignUpRequest $request): JsonResponse
    {
        try {
            $credential = $request->getCredential();
            $credential['password'] = Hash::make($credential['password']);
            /** @var \App\Models\User $user */
            $user = User::create($credential);
            if ($user) {
                Auth::login($user);
                $token = $this->getAccessToken([
                    'username' =>  $credential['email'],
                    'password' =>  $request->getCredential()['password'],
                    'grant_type' => 'password',
                    'client_id' => env('PASSPORT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                    'scope' => '*'
                ]);


                $data = [
                    'user' => $user,
                    'token' => $token
                ];
                return $this->getResponse(
                    $data,
                    __("custom.register success"),
                    'success'
                );
            } else {
                return $this->getResponse(
                    'test',
                    __("custom.register failed"),
                    'failed'
                );
            }
        } catch (\Throwable $th) {
            return $this->getResponse(
                null,
                $th->getMessage(),
                'failed'
            );
        }
    }

    /**
     * Sign out request
     *
     * @return JsonResponse
     */

    public function signOutRequest(): JsonResponse
    {
        try {
            Auth::logout();
            return $this->getResponse(
                null,
                __("custom.logout success"),
                'success'
            );
        } catch (\Throwable $th) {
            return $this->getResponse(
                null,
                $th->getMessage(),
                'failed'
            );
        }
    }

    /**
     * Refresh token request
     *
     * @param RefreshTokenRequest $request
     * @return JsonResponse
     */
    public function refreshTokenRequest(RefreshTokenRequest $request): JsonResponse
    {
        try {
            $credential = $request->getCredential();
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $token = $this->getAccessToken([
                'refresh_token' =>  $credential['refresh_token'],
                'grant_type' => 'refresh_token',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'scope' => '*'
            ]);
            $data = [
                'user' => $user,
                'token' => $token
            ];

            return $this->getResponse(
                $data,
                __("custom.refresh token success"),
                'success'
            );
        } catch (\Throwable $th) {
            return $this->getResponse(
                null,
                $th->getMessage(),
                'failed'
            );
        }
    }
}
