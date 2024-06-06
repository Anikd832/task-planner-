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
        Schema::create('routines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('day_id');
            $table->string('room_no')->nullable();
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 = active, 2 = inactive');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('day_id')->references('id')->on('days')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routines');
    }
};
