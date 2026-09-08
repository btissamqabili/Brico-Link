<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'titre',
        'description',
        'budget',
        'adresse',
        'statut',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function offres(): HasMany
{
    return $this->hasMany(Offre::class);
}
public function evaluations(): HasMany
{
    return $this->hasMany(Evaluation::class);
}
public function evaluation()
{
    return $this->hasOne(Evaluation::class);
}
}