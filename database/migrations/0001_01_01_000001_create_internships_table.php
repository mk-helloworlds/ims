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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();

            $table->string('internship_title', 255);
            $table->enum('type', [1, 2])->comment('1 = Internship 1, 2 = Internship 2');
            $table->unsignedInteger('period')->comment('months');
            $table->enum('school', ['DB', 'CS', 'TN'])->comment('DB = Digital Business, CS = Computer Science, TN = Telecom and Networking');
            $table->unsignedInteger('generation');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('internships');
    }
};
