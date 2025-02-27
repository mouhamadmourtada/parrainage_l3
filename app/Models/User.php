<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_utilisateur',
        'mot_de_passe_hash',
        'userable_type',
        'userable_id',
        'date_creation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mot_de_passe_hash',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_creation' => 'datetime',
        'mot_de_passe_hash' => 'hashed',
    ];

    /**
     * Get the parent userable model (AgentDGE, Candidat, ou Parrain).
     */
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Determine if the user can access the Filament admin panel.
     */
    public function canAccessFilamentPanel(Panel $panel): bool
    {
        return $this->userable_type === 'AgentDGE';
    }

    /**
     * Determine if the user can access the Filament admin panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true; // Temporairement permettre à tous les utilisateurs d'accéder
    }
}
