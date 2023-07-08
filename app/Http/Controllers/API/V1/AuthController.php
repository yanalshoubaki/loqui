<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Handler;
use App\Http\Requests\API\SignInRequest;
use App\Http\Requests\API\SignUpRequest;
use App\Jobs\NewUserWelcomeMail;
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
     *
     * @param SignInRequest $request
     *
     * @return JsonResponse
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
     *
     * @param \App\Http\Requests\API\SignUpRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(SignUpRequest $request): JsonResponse
    {
        try {
            $credentials = $request->getInput();
            $credentials['password'] = Hash::make($credentials['password']);
            if (!$credentials['media_object_id']) {
                $fakeImage = fake()->image('public/storage', 640, 480, null, false);
                $placeHolderImage = Image::make(public_path('storage/' . $fakeImage));
                $mediaObjectData = [
                    'media_path' => 'storage/' . $fakeImage,
                    'media_type' => 'image',
                    'media_name' => $placeHolderImage->filename,
                    'media_size' => $placeHolderImage->filesize(),
                    'media_extension' => $placeHolderImage->extension,
                    'media_mime_type' => $placeHolderImage->mime,
                ];

                $image = \App\Models\MediaObject::create($mediaObjectData);
                $credentials['media_object_id'] = $image->id;
            }
            /** @var \App\Models\User $user */
            $user = User::create($credentials);

            Auth::login($user);
            $token = $this->getAccessToken([
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'username' => $user->email,
                'password' => $request->getInput()['password'],
                'scope' => '',
            ]);
            dispatch(new NewUserWelcomeMail($user));
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
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
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
