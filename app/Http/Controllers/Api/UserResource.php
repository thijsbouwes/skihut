<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserResource extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate();

        return new JsonResponse($users);
    }

    /**
     * Display the specified resource.
     * @return JsonResponse
     */
    public function show($user_id = null) {
        $current_user = Auth::user();
        $user = null;

        // todo check $current_user if admin
        if ($user_id) {
            $user = User::with('events')->find($user_id);
        } else {
            $user = $current_user->load('events');
        }

        return new JsonResponse($user);
    }

    public function register(RegisterRequest $register_request)
    {
        $user = User::create(array_merge(
            $register_request->validated(),
            ['password' => Hash::make(str_random(35))]
        ));

        event(new Registered($user));

        return new JsonResponse($user, Response::HTTP_CREATED);
    }

    public function indexDebt()
    {
        $users = User::whereHas('events', function($query) {
            $query->where('payed_date', '=', null);
        })->paginate();

        return new JsonResponse($users);
    }
}
