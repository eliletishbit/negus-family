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
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(route('dashboard', absolute: false));
    // }

    public function store(Request $request)  {
       

        // dd($request->all());

            //on valide les données
            $request->validate([
                'email'=>['required', 'string', 'email'],
                'mot_de_passe'=>['required', 'string']
            ]);


            //on verifie si les identifiant tapés ne match pas avec celles de la bas
            if(!Auth::attempt([
                'email'=>$request->email,
                'password'=>$request->mot_de_passe
            ])){
                return back()->withErrors(['email'=>'les identifiants sont incorrectes']);
            };
            // si ca match on authentfie en creant une session pour lutilisateur
            $request->session()->regenerate();
            //puis on redirige vers la dashboard
            return redirect()->intended(route('dashboard', absolute: false));
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
