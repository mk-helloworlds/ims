<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->text('message')->nullable()->after('status'); // Message from the student
            $table->text('cv')->nullable()->after('message'); // Path to CV file
            $table->text('advisor_response_message')->nullable()->after('cv'); // Response message from the advisor
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->dropColumn(['message', 'cv', 'advisor_response_message']);
        });
    }
};
