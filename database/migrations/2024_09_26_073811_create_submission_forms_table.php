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
        Schema::create('submission_forms', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('student_request_id');
                
                $table->unsignedBigInteger('company_id');

                $table->string('supervisor_name'); 
                $table->text('internship_agreement')->nullable(); 
                $table->text('advisor_confirmation_letter')->nullable(); 
                $table->text('internship_proposal')->nullable(); 
    
                $table->timestamps(); 
    
                // Foreign key constraints
                $table->foreign('student_request_id')
                    ->references('id')->on('student_requests')
                    ->onDelete('cascade');

                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

                
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_forms');
    }
};
