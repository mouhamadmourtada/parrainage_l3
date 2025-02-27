<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Electeur;
use App\Models\Parrain;
use App\Models\User;

class Candidat extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_electeur',
        'email',
        'telephone',
        'parti_politique',
        'slogan',
        'photo_url',
        'couleur1',
        'couleur2',
        'couleur3',
        'url_page',
        'code_securite',
        'code_validation',
        'date_enregistrement',
    ];

    protected $casts = [
        'date_enregistrement' => 'datetime',
    ];

    public function electeur()
    {
        return $this->belongsTo(Electeur::class, 'numero_electeur', 'numero_electeur');
    }

    public function parrains()
    {
        return $this->hasMany(Parrain::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
