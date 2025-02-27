<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Candidat;
use App\Models\Parrain;

class Electeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'cin',
        'numero_electeur',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'bureau_vote',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function candidat()
    {
        return $this->hasOne(Candidat::class, 'numero_electeur', 'numero_electeur');
    }

    public function parrain()
    {
        return $this->hasOne(Parrain::class, 'numero_electeur', 'numero_electeur');
    }
}
