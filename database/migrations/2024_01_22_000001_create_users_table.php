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
        /**
         * TO-DO
         * 1. 마지막 로그인 일자 추가
         * 2. 친절도 추가(같이 운동하는게 확정되고 운동 종료 시간 이후에 친절도 평가가 있어야함)
         * 2-1. 친절도는 2.5kg씩 증가 또는 감소 되도록 하자.
         */
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('gender', ['man', 'woman']);
            $table->integer('age');
            $table->foreignId('gym_id')->nullable()->constrained('gyms')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
