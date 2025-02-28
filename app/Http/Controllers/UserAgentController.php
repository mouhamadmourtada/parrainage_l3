<?php

namespace App\Http\Controllers;

use App\Models\AgentDGE;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class UserAgentController extends Controller
{
    /**
     * Constructeur qui applique le middleware d'authentification
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vérifie que l'utilisateur connecté est bien un agent DGE
     */
    private function checkAgentDGEAuth()
    {
        if (!Auth::check()) {
            abort(403, 'Accès non autorisé. Authentification requise.');
        }
        
        return true;
    }

    /**
     * Affiche la liste des agents DGE
     */
    public function index()
    {
        $this->checkAgentDGEAuth();
        
        // Récupérer tous les agents DGE avec pagination
        $agents = AgentDGE::with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('agent_dge.users.index', compact('agents'));
    }

    /**
     * Affiche le formulaire d'ajout d'un nouvel agent DGE
     */
    public function create()
    {
        $this->checkAgentDGEAuth();
        
        return view('agent_dge.users.create');
    }

    /**
     * Enregistre un nouvel agent DGE
     */
    public function store(Request $request)
    {
        $this->checkAgentDGEAuth();
        
        // Validation des données
        $validator = Validator::make($request->all(), [
            // 'nom_utilisateur' => 'required|string|max:255|unique:users',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Créer l'agent DGE
            $agent = AgentDGE::create([
                'nom_utilisateur' => $request->input('email'),
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'telephone' => $request->input('telephone'),
                'est_actif' => true,
                'date_creation' => now(),
                'mot_de_pass_hash' => Hash::make($request->input('password')),
            ]);

            // Créer l'utilisateur associé à l'agent
            $user = User::create([
                'nom_utilisateur' => $request->input('email'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'userable_id' => $agent->id,
                'userable_type' => AgentDGE::class,
                'date_creation' => now(),
            ]);

            return redirect()->route('agent_dge.users.index')
                ->with('success', 'Agent DGE créé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création d\'un agent DGE : ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de l\'agent DGE : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Affiche les détails d'un agent DGE
     */
    public function show($id)
    {
        $this->checkAgentDGEAuth();
        
        $agent = AgentDGE::with('user')->findOrFail($id);
        
        return view('agent_dge.users.show', compact('agent'));
    }

    /**
     * Affiche le formulaire de modification d'un agent DGE
     */
    public function edit($id)
    {
        $this->checkAgentDGEAuth();
        
        $agent = AgentDGE::with('user')->findOrFail($id);
        
        return view('agent_dge.users.edit', compact('agent'));
    }

    /**
     * Met à jour les informations d'un agent DGE
     */
    public function update(Request $request, $id)
    {
        $this->checkAgentDGEAuth();
        
        $agent = AgentDGE::with('user')->findOrFail($id);
        
        // Validation des données
        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ];

        // Vérifier si l'email est modifié
        if ($agent->user->email !== $request->input('email')) {
            $rules['email'] = 'required|string|email|max:255|unique:users';
        } else {
            $rules['email'] = 'required|string|email|max:255';
        }

        // Vérifier si le mot de passe est fourni
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Mettre à jour l'agent DGE
            $agent->update([
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'telephone' => $request->input('telephone'),
            ]);

            // Mettre à jour l'utilisateur associé
            $userUpdate = [
                'nom_utilisateur' => $request->input('email'),
                'email' => $request->input('email'),
            ];

            // Mettre à jour le mot de passe si fourni
            if ($request->filled('password')) {
                $userUpdate['password'] = Hash::make($request->input('password'));
            }

            $agent->user->update($userUpdate);

            return redirect()->route('agent_dge.users.index')
                ->with('success', 'Agent DGE mis à jour avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour d\'un agent DGE : ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de l\'agent DGE : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Activer ou désactiver un agent DGE
     */
    public function toggleStatus($id)
    {
        $this->checkAgentDGEAuth();
        
        $agent = AgentDGE::findOrFail($id);
        
        // Ne pas permettre la désactivation de son propre compte
        if ($agent->id === Auth::user()->userable_id && Auth::user()->userable_type === AgentDGE::class) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }
        
        try {
            $agent->est_actif = !$agent->est_actif;
            $agent->save();
            
            $statusMessage = $agent->est_actif ? 'activé' : 'désactivé';
            
            return redirect()->back()
                ->with('success', 'Agent DGE ' . $statusMessage . ' avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Erreur lors du changement de statut d\'un agent DGE : ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors du changement de statut de l\'agent DGE.');
        }
    }

    /**
     * Supprimer un agent DGE
     */
    public function destroy($id)
    {
        $this->checkAgentDGEAuth();
        
        $agent = AgentDGE::findOrFail($id);
        
        // Ne pas permettre la suppression de son propre compte
        if ($agent->id === Auth::user()->userable_id && Auth::user()->userable_type === AgentDGE::class) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        
        try {
            // Supprimer l'utilisateur associé
            if ($agent->user) {
                $agent->user->delete();
            }
            
            // Supprimer l'agent DGE
            $agent->delete();
            
            return redirect()->route('agent_dge.users.index')
                ->with('success', 'Agent DGE supprimé avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression d\'un agent DGE : ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la suppression de l\'agent DGE.');
        }
    }
}