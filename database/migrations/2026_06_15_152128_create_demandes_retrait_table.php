<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes_retrait', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artiste_id')->constrained('users')->onDelete('cascade');
            $table->decimal('montant', 15, 2)->default(0);
            $table->enum('statut', ['en_attente', 'validee', 'payee', 'rejetee'])->default('en_attente');
            $table->string('reference_transfert')->nullable();
            $table->foreignId('validee_par')->nullable()->constrained('users')->onDelete('set null');
            $table->text('motif_rejet')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes_retrait');
    }
};