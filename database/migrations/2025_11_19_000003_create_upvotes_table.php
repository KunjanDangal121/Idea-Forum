<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // CHANGE THIS LINE FROM 'votes' TO 'upvotes'
        Schema::create('upvotes', function (Blueprint $table) { 
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('idea_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'idea_id']);
        });
    }

    public function down(): void
    {
        // CHANGE THIS TOO
        Schema::dropIfExists('upvotes'); 
    }
};
