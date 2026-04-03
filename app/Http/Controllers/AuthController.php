<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:128'],
            'last_name'  => ['required', 'string', 'min:2', 'max:128'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'confirmed', Password::min(12)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'password'   => $validated['password'], // cast zahashuje heslo
            'role'       => 'user',
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Registrácia prebehla úspešne.',
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Nesprávny email alebo heslo.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Prihlásenie bolo úspešné.',
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_OK);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'active_sessions' => $request->user()->tokens()->count(),
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Používateľ bol odhlásený z aktuálneho zariadenia.',
        ], Response::HTTP_OK);
    }

    public function logoutAll(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Používateľ bol odhlásený zo všetkých zariadení.',
        ], Response::HTTP_OK);
    }

    public function changePassword(Request $request) {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::min(12)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        $user = $request->user();
        $user->update(['password' => $validated['new_password']]);

        return response()->json([
            'message' => 'Heslo bolo úspešne zmenené',
        ], Response::HTTP_OK);
    }

    public function changeFirstName(Request $request) {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:128'],
        ]);

        $user = $request->user();
        $user->update(['first_name' => $validated['first_name']]);

        return response()->json([
            'message' => 'Meno bolo úspešne zmenené',
        ], Response::HTTP_OK);
    }

    public function changeLastName(Request $request) {
        $validated = $request->validate([
            'last_name' => ['required', 'string', 'min:2', 'max:128'],
        ]);

        $user = $request->user();
        $user->update(['last_name' => $validated['last_name']]);

        return response()->json([
            'message' => 'Priezvisko bolo úspešne zmenené',
        ], Response::HTTP_OK);
    }

    // z toho co som pozeral tak upload suborov ako profilova fotka vyzaduje viacere zasahy do projektu
    // tak som to radsej nespravil nech nieco nedomrvim, ked to na buducej hodine budeme robit tak ako sa to ma
}
