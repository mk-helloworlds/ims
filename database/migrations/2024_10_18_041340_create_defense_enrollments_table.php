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
        Schema::create('defense_enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('defense_request_id'); // Displaying the status -> referencing thesis_document table that have field "student_request_id", that referencing to student_requests table which have student_id, advisor_id, and internship_id.
            $table->unsignedBigInteger('jury_group_id'); //Have internship ID
            $table->date('defense_date');
            $table->enum('status',['Scheduled','Completed']);

            $table->timestamps();
            
            // FK Constraint
            $table->foreign('defense_request_id')->references('id')->on('defense_requests')->onDelete('cascade');
            $table->foreign('jury_group_id')->references('id')->on('jury_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defense_enrollments');
    }
};
