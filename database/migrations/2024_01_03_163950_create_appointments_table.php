<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->string('gender');
            $table->string('age');
            $table->string('date');
            $table->string('time');
            $table->text('case_formulation')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('feedback_id')->nullable();
            $table->foreign('feedback_id')->references('id')->on('feedback')->onDelete('set null');
            $table->string('verifyCode');
            $table->unsignedBigInteger('appointment_status_id')->default(1);
            $table->unsignedBigInteger('payment_status_id')->default(1);
            $table->foreign('appointment_status_id')->references('id')->on('appointment_statuses');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['feedback_id']);
        });
        Schema::dropIfExists('appointments');
    }
};
