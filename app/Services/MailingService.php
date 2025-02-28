<?php

namespace App\Services;

use App\Models\Parrain;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

    /**
     * Envoie le code de sécurité au candidat par email et SMS
     * 
     * @param string $email Email du candidat
     * @param string $telephone Numéro de téléphone du candidat
     * @param string $nom Nom complet du candidat
     * @param string $code Code de sécurité à envoyer
     * @return boolean
     */
    public function envoyerCodeSecurite(string $email, string $telephone, string $nom, string $code): bool
    {
        $success = true;

        // Envoi par email
        try {
            $data = [
                'nom' => $nom,
                'code' => $code
            ];

            Mail::send('emails.code-securite-candidat', $data, function ($message) use ($email, $nom) {
                $message->to($email)
                    ->subject('Code de sécurité pour votre candidature');
            });
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email avec le code de sécurité: ' . $e->getMessage());
            $success = false;
        }

        // Envoi par SMS (à implémenter avec un service SMS tiers)
        try {
            // À remplacer par l'implémentation réelle du service SMS
            Log::info("SMS envoyé au numéro {$telephone} avec le code {$code}");
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du SMS avec le code de sécurité: ' . $e->getMessage());
            $success = false;
        }

        return $success;
    }
}