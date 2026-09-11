<?php

namespace Tests\Feature;

use App\Models\Mission;
use App\Models\Offre;
use App\Models\Prestation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FactureTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_download_a_completed_prestation_invoice(): void
    {
        $client = User::factory()->client()->create();
        $prestataire = User::factory()->prestataire()->create();
        $mission = Mission::factory()->create([
            'client_id' => $client->id,
            'statut' => 'terminee',
        ]);
        $offre = Offre::factory()->create([
            'mission_id' => $mission->id,
            'prestataire_id' => $prestataire->id,
        ]);
        $prestation = Prestation::create([
            'offre_id' => $offre->id,
            'mission_id' => $mission->id,
            'prestataire_id' => $prestataire->id,
            'date_debut' => now()->subDay(),
            'date_fin' => now(),
            'statut' => 'terminee',
            'montant' => 450,
        ]);

        $this->actingAs($client)
            ->get(route('prestations.facture', $prestation))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_unrelated_user_cannot_download_a_prestation_invoice(): void
    {
        $client = User::factory()->client()->create();
        $prestataire = User::factory()->prestataire()->create();
        $otherUser = User::factory()->client()->create();
        $mission = Mission::factory()->create([
            'client_id' => $client->id,
            'statut' => 'terminee',
        ]);
        $offre = Offre::factory()->create([
            'mission_id' => $mission->id,
            'prestataire_id' => $prestataire->id,
        ]);
        $prestation = Prestation::create([
            'offre_id' => $offre->id,
            'mission_id' => $mission->id,
            'prestataire_id' => $prestataire->id,
            'statut' => 'terminee',
            'montant' => 450,
        ]);

        $this->actingAs($otherUser)
            ->get(route('prestations.facture', $prestation))
            ->assertForbidden();
    }
}
