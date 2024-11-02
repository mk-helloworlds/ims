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
        Schema::create('thesis_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_request_id');
            
            $table->text('student_thesis')->nullable(); 

            $table->enum('status', ['submitted', 'accepted', 'rejected'])->default('submitted');
            
            // $table->unsignedBigInteger('user_student_id');
            // $table->unsignedBigInteger('user_advisor_id');
            // $table->unsignedBigInteger('internship_id');

            // $table->enum('status', ['submitted', 'Accepted', 'Rejected'])->default('N/A');

            // Foreign key constraints
            // $table->foreign('user_student_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('user_advisor_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('internship_id')->references('id')->on('internships')->onDelete('cascade');

            $table->foreign('student_request_id')
                  ->references('id')->on('student_requests')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_documents');
    }
};
