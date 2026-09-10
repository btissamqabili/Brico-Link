<?php

namespace App\Events;

use App\Models\Offre;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NouvelleOffreCreee
{
    use Dispatchable, SerializesModels;

    /**
     * L'offre nouvellement créée.
     */
    public function __construct(
        public Offre $offre
    ) {
    }
}

