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
        Schema::create('coordinators_departments_subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('coordinator_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('department_id');
            $table->date('Exam_Date');
            $table->string('name')->default('لا يوجد بيانات');
            $table->date('time')->nullable();
            $table->boolean('status')->default(0);
        
            // المفتاح الأساسي المركب
            $table->primary(['coordinator_id', 'subject_id', 'department_id']);
        
            // المفاتيح الخارجية
            $table->foreign('coordinator_id')->references('id')->on('coordinators')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinators_departments_subjects');
    }
};
