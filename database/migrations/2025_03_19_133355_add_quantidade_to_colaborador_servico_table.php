<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantidadeToColaboradorServicoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('colaborador_servico', function (Blueprint $table) {
            $table->integer('quantidade')->default(1)->after('servico_id'); // Adiciona a coluna "quantidade"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('colaborador_servico', function (Blueprint $table) {
            $table->dropColumn('quantidade'); // Remove a coluna "quantidade"
        });
    }
}
