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
        Schema::create('internship_projects', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_request_id');
         
            $table->foreign('student_request_id')
                  ->references('id')->on('student_requests')
                  ->onDelete('cascade');

            $table->string('project_name',255);
            $table->text('description');

            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_projects');
    }
};
