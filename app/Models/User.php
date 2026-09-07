<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Evaluation;


#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'telephone',
    'adresse',
    'photo',
    'description',
    'competences',
    'experience',
    'disponibilite',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    public function services(): HasMany
{
    return $this->hasMany(Service::class, 'prestataire_id');
}
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
        'experience' => 'integer',
    ];
}
public function missions(): HasMany
{
    return $this->hasMany(Mission::class, 'client_id');
}
public function offres(): HasMany
{
    return $this->hasMany(Offre::class, 'prestataire_id');
}
public function evaluationsAsClient()
{
    return $this->hasMany(Evaluation::class, 'client_id');
}

public function evaluationsAsPrestataire()
{
    return $this->hasMany(Evaluation::class, 'prestataire_id');
}
public function evaluationsRecues()
{
    return $this->hasMany(Evaluation::class, 'prestataire_id');
}

}