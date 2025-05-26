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
    Schema::table('vendas', function (Blueprint $table) {
        $table->boolean('status')->default(0)->change(); // Altera o tipo para TINYINT (boolean)
    });
}

public function down()
{
    Schema::table('vendas', function (Blueprint $table) {
        $table->string('status')->default('em progresso')->change(); // Reverte para string
    });
}
};
