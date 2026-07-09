<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->integer('num_livraison')->unique();
            // Liens vers les autres tables
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('livreur_id')->constrained('users')->onDelete('cascade');
            
            $table->date('date_livraison')->nullable();
            $table->string('statut')->default('en_attente');
            $table->string('adresse');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};

