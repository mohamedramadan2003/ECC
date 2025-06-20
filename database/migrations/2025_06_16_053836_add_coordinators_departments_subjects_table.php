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
       Schema::table('coordinators_departments_subjects', function (Blueprint $table) {
                $table->unsignedBigInteger('committee_number');
                $table->foreign('committee_number')->references('committee_number')->on('locations')->onDelete('cascade');
                 $table->unique(['coordinator_id', 'subject_id', 'department_id' , 'committee_number']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
