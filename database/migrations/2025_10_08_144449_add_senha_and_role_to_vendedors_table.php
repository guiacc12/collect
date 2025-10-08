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
        Schema::table('vendedors', function (Blueprint $table) {
            $table->string('senha')->nullable()->after('email');
            $table->enum('role', ['admin', 'vendor'])->default('vendor')->after('senha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendedors', function (Blueprint $table) {
            $table->dropColumn(['senha', 'role']);
        });
    }
};
