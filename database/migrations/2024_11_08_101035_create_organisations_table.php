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
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('adres')->nullable();
            $table->string('stad')->nullable();
            $table->string('url_locatie')->nullable();
            $table->string('url_website')->nullable();
            $table->string('foto_pad')->nullable();
            $table->string('kleur_achtergrond')->nullable();
            $table->string('kleur_thema')->nullable();
            $table->string('kleur_thema2')->nullable();
            $table->string('kleur_tekst')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
