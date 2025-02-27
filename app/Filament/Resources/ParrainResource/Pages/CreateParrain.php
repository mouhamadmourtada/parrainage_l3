<?php

namespace App\Filament\Resources\ParrainResource\Pages;

use App\Filament\Resources\ParrainResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CreateParrain extends CreateRecord
{
    protected static string $resource = ParrainResource::class;

    protected function beforeCreate(): void
    {
        // Vérifier si l'électeur existe et peut être parrain
        $cin = $this->data['cin'];
        $numero_electeur = $this->data['numero_electeur'];
        $nom = $this->data['nom'];
        $bureau_vote = $this->data['bureau_vote'];

        $canBeParrain = DB::select("SELECT PeutEtreParrain(?, ?, ?, ?) as result", [
            $numero_electeur,
            $cin,
            $nom,
            $bureau_vote
        ])[0]->result;

        if (!$canBeParrain) {
            $this->halt();
            $this->notify('danger', 'Cette personne ne peut pas être parrain. Vérifiez les informations saisies.');
        }
    }

    protected function afterCreate(): void
    {
        // Créer un compte utilisateur pour le parrain
        try {
            $user = \App\Models\User::create([
                'name' => $this->record->prenom . ' ' . $this->record->nom,
                'email' => $this->record->numero_electeur . '@parrainage.sn',
                'username' => $this->record->numero_electeur,
                'password' => bcrypt($this->record->cin),
                'userable_id' => $this->record->id,
                'userable_type' => 'App\\Models\\Parrain'
            ]);

            $this->notify('success', 'Compte créé avec succès. Identifiant: ' . $user->username . ' / Mot de passe: ' . $this->record->cin);
        } catch (QueryException $e) {
            $this->notify('warning', 'Le parrain a été créé mais une erreur est survenue lors de la création du compte.');
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
