<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Electeur;
use App\Models\Candidat;

class Parrain extends Model
{
    use HasFactory;

    protected $table = 'parrains';

    protected $fillable = [
        'numero_electeur',
        'candidat_id',
        'telephone',
        'email',
        'code_authentification',
        'code_validation',
        'date_inscription'
    ];

    protected $casts = [
        'date_inscription' => 'datetime',
    ];

    public function electeur()
    {
        return $this->belongsTo(Electeur::class, 'numero_electeur', 'numero_electeur');
    }

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
