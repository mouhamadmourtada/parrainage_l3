<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueUpload extends Model
{
    use HasFactory;

    protected $casts = [
        'date_upload' => 'datetime',
    ];

    protected $fillable = [
        'date_upload',
        'nom_fichier',
        'type_fichier',
        'nombre_lignes',
        'nombre_lignes_ajoutees',
        'nombre_lignes_modifiees',
        'nombre_lignes_supprimees',
        'agent_dge_id',
    ];

    /**
     * Obtenir l'agent DGE associé à cet upload
     */
    public function agentDge()
    {
        return $this->belongsTo(AgentDGE::class, 'agent_dge_id');
    }

    /**
     * Obtenir les problèmes d'électeurs associés à cet upload
     */
    public function problemes()
    {
        return $this->hasMany(ElecteurProbleme::class, 'upload_id');
    }
}
