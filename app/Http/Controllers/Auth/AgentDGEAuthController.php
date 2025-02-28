<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AgentDGE;

class AgentDGEAuthController extends Controller
{
    /**
     * Affiche le formulaire d'authentification pour les agents DGE
     */
    public function showLoginForm()
    {
        return view('auth.agent_dge_login');
    }

    /**
     * Traite la tentative d'authentification
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenter de connecter l'utilisateur
        if (Auth::attempt($credentials)) {
            // Vérifier si l'utilisateur connecté est bien un agent DGE
            $user = Auth::user();
            
            if ($user->userable_type === 'App\\Models\\AgentDGE') {
                $request->session()->regenerate();
                return redirect()->intended(route('agent_dge.dashboard'));
            } else {
                // Si ce n'est pas un agent DGE, déconnecter
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Ces identifiants ne correspondent pas à un compte Agent DGE.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent à aucun utilisateur.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('agent_dge.login');
    }
}