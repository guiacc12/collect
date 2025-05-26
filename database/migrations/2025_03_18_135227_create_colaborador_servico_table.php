<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('colaborador_servico', function (Blueprint $table) {
        $table->id();
        $table->foreignId('colaborador_id')->constrained('colaboradores')->onDelete('cascade');
        $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
        $table->decimal('valor', 10, 2);
        $table->date('data_producao');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaborador_servico');
    }
};
