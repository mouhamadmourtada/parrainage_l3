<?php

namespace App\Services;

use App\Models\Parrain;
use Illuminate\Support\Facades\Mail;

class MailingService
{
    /**
     * Envoie un email au parrain après son inscription
     * 
     * @param Parrain $parrain Le parrain nouvellement créé
     * @param string $password Le mot de passe en clair pour l'envoi
     * @return boolean
     */
    public function envoyerMailActivationCompte(Parrain $parrain, string $password): bool
    {
        try {
            $data = [
                'username' => $parrain->numero_electeur,
                // 'password' => $password,
                'prenom' => request()->prenom ?? 'Parrain',
                'nom' => request()->nom ?? '',
                'code_authentification' => $parrain->code_authentification
            ];

            Mail::send('emails.activation-compte', $data, function ($message) use ($parrain) {
                $message->to($parrain->email)
                    ->subject('Activation de votre compte parrain');
            });

            return true;
        } catch (\Exception $e) {
            // Logger l'erreur mais ne pas interrompre le flux d'inscription
            \Log::error('Erreur lors de l\'envoi de l\'email d\'activation: ' . $e->getMessage());
            
            return false;
        }
    }
}