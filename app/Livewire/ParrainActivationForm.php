<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ParrainActivationForm extends Component
{
    public $numero_electeur;
    public $cin;
    public $nom;
    public $bureau_vote;
    
    // Propriétés pour les erreurs individuelles et générales
    public $errorMessages = [];
    public $generalError = '';

    protected $rules = [
        'numero_electeur' => 'required',
        'cin' => 'required',
        'nom' => 'required',
        'bureau_vote' => 'required',
    ];

    protected $messages = [
        'required' => 'Ce champ est obligatoire.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->resetErrorFor($propertyName);
    }

    private function resetErrorFor($field)
    {
        if (isset($this->errorMessages[$field])) {
            unset($this->errorMessages[$field]);
        }
    }

    public function verify()
    {
        $this->generalError = '';
        $this->errorMessages = [];

        // Valider les champs
        $validatedData = $this->validate();
        
        try {
            // Appel direct au contrôleur sans passer par Ajax
            $controller = app(\App\Http\Controllers\ParrainController::class);
            
            // Créer une requête avec les données du formulaire
            $request = new \Illuminate\Http\Request();
            $request->replace([
                'numero_electeur' => $this->numero_electeur,
                'cin' => $this->cin,
                'nom' => $this->nom,
                'bureau_vote' => $this->bureau_vote,
            ]);
            
            // Définir les données de session (simuler ce que le middleware de Laravel ferait)
            $request->setLaravelSession(session());
            
            // Appeler la méthode du contrôleur
            $response = $controller->verifyElecteur($request);
            
            // Si la réponse est un JsonResponse, traiter en conséquence
            if (method_exists($response, 'getStatusCode') && $response->getStatusCode() === 200) {
                // Redirection vers la page suivante
                return redirect()->route('parrain.contact');
            } else {
                // Gérer les erreurs spécifiques
                $responseData = json_decode($response->getContent(), true);
                if (isset($responseData['errors'])) {
                    foreach ($responseData['errors'] as $field => $errors) {
                        if ($field === 'general') {
                            $this->generalError = $errors[0];
                        } else {
                            $this->errorMessages[$field] = $errors;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Gérer les erreurs générales
            $this->generalError = "Une erreur est survenue lors de la vérification. Veuillez réessayer.";
        }
    }

    public function render()
    {
        return view('livewire.parrain-activation-form');
    }
}
