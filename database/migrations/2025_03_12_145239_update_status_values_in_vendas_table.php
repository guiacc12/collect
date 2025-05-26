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
    // Atualiza os valores da coluna 'status'
    DB::table('vendas')->where('status', 'em progresso')->update(['status' => 0]);
    DB::table('vendas')->where('status', 'concluido')->update(['status' => 1]);
}

public function down()
{
    // Reverte os valores da coluna 'status'
    DB::table('vendas')->where('status', 0)->update(['status' => 'em progresso']);
    DB::table('vendas')->where('status', 1)->update(['status' => 'concluido']);
}
};
