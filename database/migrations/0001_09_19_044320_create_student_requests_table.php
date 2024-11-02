<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('student_requests', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('internship_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('advisor_id'); 
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending');

            // FOREIGN KEY CONSTRIANT
            $table->foreign('internship_id')
            ->references('id')->on('internships')
            ->onDelete('cascade');

            $table->foreign('student_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->foreign('advisor_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_requests');
    }
};
