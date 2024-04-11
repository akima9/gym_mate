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
         * 1. 친절도 추가(같이 운동하는게 확정되고 운동 종료 시간 이후에 친절도 평가가 있어야함)
         * 1-1. 친절도는 5kg씩 증가 또는 감소 되도록 하자.(친절근)
         * 채팅화면에 확정 기능 추가
         * 확정 기록 테이블 추가
         * 알림 테이블 추가
         * 친절근 업다운 페이지 추가
         */
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('gender', ['man', 'woman']);
            $table->integer('age');
            $table->integer('kindness')->default(100);
            $table->foreignId('gym_id')->nullable()->constrained('gyms')->nullOnDelete();
            $table->rememberToken();
            $table->timestamp('last_login')->nullable();
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
