<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Validator::extend('valid_username', function($attr, $value){
            return preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $value);
        });

        $request->validate([
            "surname" => "required|string|max:255",
            "first_name" =>"required|string|max:255",
            "middle_name" =>"required|string|max:255",
            "name_extension" =>"string|max:255|nullable",
            'username' => 'required|string|valid_username|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'username.valid_username' => 'Invalid Username.'
        ]);

        $user = User::create([
            "surname" =>  $request->surname,
            "first_name" => $request->first_name,
            "middle_name" => $request->middle_name,
            "name_extension" => $request->name_extension,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
