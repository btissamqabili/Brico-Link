<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Categorie extends Model
{
    protected $fillable = [
        'nom',
        'description',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}