<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('student_submissions', function (Blueprint $table) {
        $table->id();
        $table->string('email')->unique();
        $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('cascade');
        $table->string('cv_file');  // File path for the CV
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
        $table->timestamps();
    });
}
    public function down()
    {
        Schema::dropIfExists('student_submissions');
    }
};
