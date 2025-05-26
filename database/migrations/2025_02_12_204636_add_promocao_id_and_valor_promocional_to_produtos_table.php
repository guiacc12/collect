<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->unsignedBigInteger('promocao_id')->nullable()->after('categoria_id');
            $table->decimal('valor_promocional', 8, 2)->nullable()->after('valor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('promocao_id');
            $table->dropColumn('valor_promocional');
        });
    }
};
