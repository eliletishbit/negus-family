<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('titres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artiste_id')->constrained('users')->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->decimal('prix', 15, 2)->default(0);
            $table->decimal('commission', 5, 2)->default(0);
            $table->string('fichier_apercu')->nullable();
            $table->string('fichier_complet')->nullable();
            $table->enum('type', ['son', 'video'])->default('son');
            $table->integer('nb_ventes')->default(0);
            $table->enum('status', ['en_attente', 'publie', 'rejete'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('titres');
    }
};