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
        Schema::table('evento_grupos', function (Blueprint $table) {
            // Crie os campos de soft delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evento_grupos', function (Blueprint $table) {
            // Remova os campos de soft delete
            $table->dropSoftDeletes();
        });
    }
};
