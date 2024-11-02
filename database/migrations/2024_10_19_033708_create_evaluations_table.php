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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_student_id');
            $table->unsignedBigInteger('user_jury_id');
            $table->unsignedBigInteger('defense_enrollment_id');
            $table->unsignedBigInteger('question_id');

            $table->integer('score'); 
            $table->text('feedback')->nullable(); 
            $table->text('note')->nullable(); 

            $table->timestamps();

            // FK Constraint
            $table->foreign('user_student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_jury_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('defense_enrollment_id')->references('id')->on('defense_enrollments')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('evaluation_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
