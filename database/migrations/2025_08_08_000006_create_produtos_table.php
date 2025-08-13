<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete()->onUpdate('restrict');
            $table->foreignId('promocao_id')->nullable()->constrained('promocaos')->nullOnDelete()->onUpdate('restrict');
            $table->text('imagem')->nullable();
            $table->string('titulo')->nullable();
            $table->string('descricao', 1000)->nullable();
            $table->string('valor')->nullable();
            $table->decimal('valor_promocional', 8, 2)->nullable();
            $table->string('slug')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('produtos');
    }
};