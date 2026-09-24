<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('num_commande');
        });

        Schema::table('livraisons', function (Blueprint $table) {
            $table->dropUnique(['num_livraison']);
            $table->dropColumn('num_livraison');
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->integer('num_commande')->nullable()->after('id');
        });

        Schema::table('livraisons', function (Blueprint $table) {
            $table->integer('num_livraison')->nullable()->unique()->after('id');
        });
    }
};