<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lignes_commande', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('titre_id')->nullable()->constrained('titres')->onDelete('set null');
            $table->foreignId('produit_id')->nullable()->constrained('produits')->onDelete('set null');
            $table->decimal('prix_unitaire', 15, 2)->default(0);
            $table->integer('quantite')->default(1);
            $table->decimal('commission_ligne', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lignes_commande');
    }
};