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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('alias')->nullable();   
            $table->string('kleur_achtergrond')->nullable();
            $table->string('kleur_thema')->nullable();
            $table->string('kleur_thema2')->nullable();
            $table->string('kleur_tekst')->nullable();        
            $table->string('device_id')->unique();
            $table->string('ip_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
