<?php

namespace App\Filament\Resources\ParrainResource\Pages;

use App\Filament\Resources\ParrainResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditParrain extends EditRecord
{
    protected static string $resource = ParrainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        // Vérifier si l'électeur existe et peut être parrain
        $cin = $this->data['cin'];
        $numero_electeur = $this->data['numero_electeur'];
        $nom = $this->data['nom'];
        $bureau_vote = $this->data['bureau_vote'];

        if ($this->record->cin !== $cin || 
            $this->record->numero_electeur !== $numero_electeur ||
            $this->record->nom !== $nom ||
            $this->record->bureau_vote !== $bureau_vote) {
            
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
    }

    protected function afterSave(): void
    {
        // Mettre à jour le compte utilisateur associé
        if ($this->record->user) {
            $this->record->user->update([
                'name' => $this->record->prenom . ' ' . $this->record->nom,
                'email' => $this->record->numero_electeur . '@parrainage.sn',
                'username' => $this->record->numero_electeur,
            ]);
        }
    }
}
