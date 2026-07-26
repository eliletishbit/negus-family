<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('commission_totale', 15, 2)->default(0);
            $table->enum('mode_livraison', ['electronique', 'physique'])->default('electronique');
            $table->enum('statut', ['en_attente', 'paye', 'annule'])->default('en_attente');
            $table->string('ref_fedapay')->nullable();
            $table->enum('methode_paiement', ['fedapay', 'moovmoney', 'mtnmoney'])->nullable();
            $table->date('date_livraison')->nullable();
            $table->text('adresse_livraison')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};