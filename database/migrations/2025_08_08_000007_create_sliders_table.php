<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->text('banner')->nullable();
            $table->string('titulo')->nullable();
            $table->string('descricao', 500)->nullable();
            $table->string('starting_price')->nullable();
            $table->string('slug')->nullable();
            $table->integer('promocao')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sliders');
    }
};