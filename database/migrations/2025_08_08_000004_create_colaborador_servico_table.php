<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('colaborador_servico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colaborador_id')->constrained('colaboradores')->onDelete('cascade')->onUpdate('restrict');
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade')->onUpdate('restrict');
            $table->integer('quantidade')->default(1);
            $table->decimal('valor', 10, 2);
            $table->date('data_producao');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('colaborador_servico');
    }
};