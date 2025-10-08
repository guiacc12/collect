<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vendedors', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('telefone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->decimal('comissao', 8, 2)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('vendedors');
    }
};
