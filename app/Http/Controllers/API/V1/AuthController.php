<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Handler;
use App\Http\Requests\API\SignInRequest;
use App\Http\Requests\API\SignUpRequest;
use App\Models\User;
use App\Traits\UserOauthTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AuthController extends Handler
{
    use UserOauthTrait;

    /**
     * Sign in request
     */
    public function signIn(SignInRequest $request): JsonResponse
    {
        try {
            $credentials = $request->getInput();
            if (! Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],

            ], $credentials['remember_me'] ?? false)) {
                return $this->responseError('Unauthorized', 401);
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $token = $this->getAccessToken([
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'username' => $user->email,
                'password' => $credentials['password'],
                'scope' => '',
            ]);

            return $this->responseSuccess([
                'token' => $token,
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }

    /**
     * Sign Up Request
     */
    public function signUp(SignUpRequest $request): JsonResponse
    {
        try {
            $credentials = $request->getInput();
            $credentials['password'] = Hash::make($credentials['password']);
            $image = fake()->image(storage_path('app/public'), 500, 500, null, false);
            $placeHolderImage = Image::make(public_path('storage/'.$image));
            $image = [
                'media_path' => 'storage/'.$image,
                'media_type' => 'image',
                'media_name' => $placeHolderImage->filename,
                'media_size' => $placeHolderImage->filesize(),
                'media_extension' => $placeHolderImage->extension,
                'media_mime_type' => $placeHolderImage->mime,
            ];
            $image = \App\Models\MediaObject::create($image);
            $credentials['media_object_id'] = $image->id;
            /** @var \App\Models\User $user */
            $user = User::create($credentials);

            Auth::login($user);
            $token = $this->getAccessToken([
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'username' => $user->email,
                'password' => $credentials['password'],
                'scope' => '',
            ]);

            return $this->responseSuccess([
                'token' => $token,
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }

    /**
     * Sign out request
     */
    public function signOut(Request $request): JsonResponse
    {
        try {
            $request->user()->token()->revoke();

            return $this->responseSuccess([
                'message' => 'Successfully logged out',
            ]);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }
}
