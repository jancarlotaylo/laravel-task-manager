<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationAuthenticateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    /**
     * Show the login form.
     *
     * @return View The view displaying the login form.
     */
    public function login(): View
    {
        return view('login');
    }

    /**
     * Authenticate the user and log them in.
     *
     * @param AuthenticationAuthenticateRequest $request The validated request data for authentication.
     * @return RedirectResponse Redirect to the intended route or the home page.
     */
    public function authenticate(
        AuthenticationAuthenticateRequest $request
    ): RedirectResponse
    {
        // Attempt to log the user in
        if (Auth::attempt($request->validated(), $request->remember)) {
            // Authentication was successful
            return redirect()->intended(route('/'));
        }

        // Authentication failed, redirect back with an error
        return back()->withErrors([
            'email' => 'Invalid login.',
        ])->onlyInput('email'); // Keep the placed email to prevent user from re-typing
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request The incoming request to invalidate the session.
     * @return RedirectResponse Redirect the user to the login page after logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session to prevent session fixation
        $request->session()->invalidate();

        // Regenerate the session to prevent session hijacking
        $request->session()->regenerateToken();

        // Redirect the user to the login page
        return redirect()->route('login');
    }
}
