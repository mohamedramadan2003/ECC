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
        Schema::create('departments_subjects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->unsigned();;
            $table->bigInteger('subject_id')->unsigned();;
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->enum('level',['الاول','الثاني','الثالث','الرابع']);
            $table->enum('term',['الاول','الثاني']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments_subjects');
    }
};
