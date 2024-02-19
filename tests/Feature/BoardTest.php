<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoardTest extends TestCase
{
    public function test_메이트_모집_게시물_목록_페이지_접속_가능합니다(): void
    {
        $response = $this->get('/');
        $response->assertRedirectToRoute('boards.index');
        $response->assertStatus(302);
    }

    public function test_로그인_전_메이트_모집_게시물_작성_페이지_접속시_로그인_페이지로_이동합니다(): void
    {
        $response = $this->get('/boards/create');
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }
}
