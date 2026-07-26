<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            
            // Liaison avec ta table commandes (grâce à commande_id)
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            
            // L'ID unique de la transaction renvoyé par FedaPay (ex: id de la transaction chez eux)
            $table->string('fedapay_transaction_id')->unique();
            
            // Le montant réel reçu du processeur
            $table->decimal('montant', 15, 2);
            
            // La devise utilisée (par défaut le FCFA)
            $table->string('devise', 5)->default('XOF');
            
            // Le moyen de paiement utilisé par le client (ex: mtn, moov, wave, card)
            $table->string('mode_paiement')->nullable();
            
            // Le statut du paiement (ex: approved, declined, refunded)
            $table->string('statut');
            
            // Référence externe ou numéro de reçu fourni par FedaPay si besoin
            $table->string('reference_paiement')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
