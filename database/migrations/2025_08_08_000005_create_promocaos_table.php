<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('promocaos', function (Blueprint $table) {
            $table->id();
            $table->text('imagem')->nullable();
            $table->string('titulo')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('status')->nullable();
            $table->dateTime('inicio')->nullable();
            $table->dateTime('fim')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('promocaos');
    }
};