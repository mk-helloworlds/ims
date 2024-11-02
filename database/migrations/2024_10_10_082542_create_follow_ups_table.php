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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_request_id');

            $table->date('follow_up_date'); 
            $table->text('notes')->nullable(); 
            $table->enum('status', ['On Track', 'Behind Schedule', 'Completed']);

            $table->foreign('student_request_id')->references('id')->on('student_requests')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
