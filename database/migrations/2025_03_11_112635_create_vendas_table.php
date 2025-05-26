<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendedor_id')->constrained('vendedors')->onDelete('cascade');
            $table->string('produto_nome');
            $table->string('comprador_nome');
            $table->integer('quantidade');
            $table->decimal('valor_venda', 10, 2);
            $table->string('status')->default('em progresso');
            $table->string('cpf_cnpj');
            $table->string('cep');
            $table->string('rua');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};

