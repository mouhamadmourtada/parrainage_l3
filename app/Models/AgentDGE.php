<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\HistoriqueUpload;

class AgentDGE extends Model
{
    use HasFactory;

    protected $table = 'agent_dge';

    protected $fillable = [
        'nom_utilisateur',
        'password',
        'nom',
        'prenom',
        'date_creation',
    ];

    protected $casts = [
        'date_creation' => 'datetime',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function historiqueUploads()
    {
        return $this->hasMany(HistoriqueUpload::class);
    }
}
