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
        Schema::table('jobs', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained();
            $table->foreignId('company_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign('jobs_category_id_foreign');
            $table->dropForeign('jobs_company_id_foreign');
            $table->dropColumn('category_id');
            $table->dropColumn('company_id');
        });
    }
};
