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
        Schema::create('public_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titel'); 
            $table->date('datum'); 
            $table->time('tijd'); 
            $table->string('adres')->nullable(); 
            $table->string('stad'); 
            $table->string('url_locatie')->nullable();
            $table->string('categorie');  
            $table->string('url_evenement')->nullable();
            $table->text('beschrijving')->nullable(); 
            $table->string('achtergrond_pad')->nullable(); 
            $table->string('kleur')->nullable();          
            $table->string('foto_pad')->nullable();
            $table->integer('zoom')->default(100);
            $table->integer('horizontaal')->default(50);
            $table->integer('verticaal')->default(50);         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_events');
    }
};
