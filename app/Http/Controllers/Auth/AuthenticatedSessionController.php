<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. On vérifie l'email + mot de passe (avec le throttling existant)
        $request->authenticate();

        $user = Auth::user();

        // 2. Si la 2FA est activée ET confirmée pour cet utilisateur,
        //    on annule cette connexion "classique" et on redirige
        //    vers l'écran de vérification du code à 6 chiffres.
        if ($user->two_factor_secret && $user->two_factor_confirmed_at) {

            Auth::logout();

            $request->session()->put([
                'login.id' => $user->getKey(),
                'login.remember' => $request->boolean('remember'),
            ]);

            return redirect()->route('two-factor.login');
        }

        // 3. Sinon (pas de 2FA), connexion normale comme avant
        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        if ($user->role === 'livreur') {
            return redirect()->intended('/livreur');
        }

        return redirect()->intended('/dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}