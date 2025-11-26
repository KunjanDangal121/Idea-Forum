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
    Schema::table('ideas', function (Blueprint $table) {
        // Add status_id column and set its default value to 1 (Assuming 1 = 'Open')
        $table->foreignId('status_id')->default(1)->constrained()->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('ideas', function (Blueprint $table) {
        // Drop the foreign key constraint first
        $table->dropForeign(['status_id']);
        // Then drop the column
        $table->dropColumn('status_id');
    });
}
};
