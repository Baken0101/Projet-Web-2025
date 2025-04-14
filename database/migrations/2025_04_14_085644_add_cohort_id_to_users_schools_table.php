<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users_schools', function (Blueprint $table) {
            $table->foreignId('cohort_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users_schools', function (Blueprint $table) {
            $table->dropForeign(['cohort_id']);
            $table->dropColumn('cohort_id');
        });
    }

};
