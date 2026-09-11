<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('offre_id')
                ->unique()
                ->constrained('offres')
                ->cascadeOnDelete();

            $table->foreignId('mission_id')
                ->constrained('missions')
                ->cascadeOnDelete();

            $table->foreignId('prestataire_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamp('date_debut')->nullable();
            $table->timestamp('date_fin')->nullable();
            $table->enum('statut', ['en_cours', 'terminee', 'annulee'])
                ->default('en_cours');
            $table->decimal('montant', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestations');
    }
};
