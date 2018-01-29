<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserResource extends Controller
{
    /**
     * Display the specified resource.
     * @return JsonResponse
     */
    public function show() {
        $user = Auth::user();
        return new JsonResponse($user);
    }

    public function register(RegisterRequest $register_request)
    {
        $user = User::create(
            $register_request->validated()
        );

        event(new Registered($user));

        return new JsonResponse($user, Response::HTTP_CREATED);
    }
}
