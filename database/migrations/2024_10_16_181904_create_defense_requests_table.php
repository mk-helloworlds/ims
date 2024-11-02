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
        Schema::create('defense_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('thesis_document_id'); 
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); 
            $table->text('feedback')->nullable(); 

            // Foreign key constraint
            $table->foreign('thesis_document_id')->references('id')->on('thesis_documents')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defense_requests');
    }
};
