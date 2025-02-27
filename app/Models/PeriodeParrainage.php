<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeParrainage extends Model
{
    use HasFactory;

    protected $table = 'periodes_parrainage';

    protected $fillable = [
        'date_debut',
        'date_fin',
        'est_active',
        'description'
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'est_active' => 'boolean'
    ];

    /**
     * Vérifie si une période donnée est valide
     * (date de début > maintenant + 6 mois)
     */
    public function estPeriodeValide(): bool
    {
        return $this->date_debut->greaterThan(now()->addMonths(6));
    }

    /**
     * Vérifie si la période est actuellement active
     */
    public function estEnCours(): bool
    {
        $maintenant = now();
        return $this->est_active && 
               $maintenant->greaterThanOrEqualTo($this->date_debut) && 
               $maintenant->lessThanOrEqualTo($this->date_fin);
    }

    /**
     * Désactive toutes les autres périodes et active celle-ci
     */
    public function activer(): void
    {
        self::query()->update(['est_active' => false]);
        $this->update(['est_active' => true]);
    }
}
