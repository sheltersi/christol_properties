<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         $user = Auth::user();

    //         $tenant = new Tenant;

    //         // add the nested relation(s) in one shot
    //         $tenant->load('currentLease.cottage');   // can chain more: ->load('currentLease.payments')


    //         // Redirect by role
    //         if ($user->role === 'admin') {
    //             return redirect()->route('admin.dashboard');

    //         } elseif ($user->role === 'tenant') {
    //             return redirect()->route('tenant.dashboard');
    //         }

    //         return redirect()->intended('/');
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);

    //     // return redirect()->intended(route('dashboard', absolute: false));
    // }

    public function store(LoginRequest $request): RedirectResponse
{
    // 1. Auth & session‑fixation handled once
    $request->authenticate();
    $request->session()->regenerate();

    /** @var \App\Models\User $user */
    $user = $request->user(); // already logged in

    // 2. If you really need the tenant + cottage for the *next page*,
    //    eager‑load on the User model, not here. Example:
    // $user->load('tenant.currentLease.cottage');

    // 3. Role‑based redirect
    return match ($user->role) {
        'admin'  => redirect()->route('admin.dashboard'),
        'tenant' => redirect()->route('tenant.dashboard'),
        default  => redirect()->intended('/'),
    };
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
