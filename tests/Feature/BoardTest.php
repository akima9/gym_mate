<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoardTest extends TestCase
{
    use RefreshDatabase;

    public function test_01_메이트_모집_게시물_목록_페이지_접속_가능(): void
    {
        //Act
        $response = $this->get('/');
        
        //Assert
        $response->assertStatus(302);
        $response->assertRedirectToRoute('boards.index');
    }

    public function test_02_로그인_X_메이트_모집_게시물_작성_페이지_접속시_로그인_페이지로_이동(): void
    {
        //Act
        $response = $this->get(route('boards.create'));

        //Assert
        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
    }
    
    public function test_03_로그인_O_메이트_모집_게시물_작성_페이지_접속_가능(): void
    {
        //Create a user using the factory
        $user = User::factory()->create();

        //Act
        $response = $this->actingAs($user)->get(route('boards.create'));
        
        //Assert
        $response->assertStatus(200);
        $response->assertViewIs('board.create');
    }

    public function test_04_로그인_O_GYM_설정_X_메이트_모집_게시물_작성시_프로필_편집_페이지로_이동(): void
    {
        //Create a user using the factory
        $user = User::factory()->create();

        //Act
        $response = $this->actingAs($user)->post(route('boards.store'), [
            'title' => '제목입니다.',
            'content' => '내용입니다.',
        ]);

        //Assert
        $response->assertStatus(302);
        $response->assertRedirectToRoute('profile.edit');
        $this->expectsDatabaseQueryCount(0);
    }

    public function test_05_로그인_O_GYM_설정_O_메이트_모집_게시물_작성_가능(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        
        //Act
        $response = $this->actingAs($user)->post(route('boards.store'), [
            'title' => '제목입니다.',
            'content' => '내용입니다.',
        ]);
        
        //Assert
        $board = Board::latest()->first();
        $response->assertStatus(302);
        $response->assertRedirectToRoute('boards.show', ['board' => $board]);
        $this->assertDatabaseHas('boards', [
            'title' => '제목입니다.',
            'content' => '내용입니다.',
        ]);
    }

    public function test_06_로그인_X_메이트_모집_게시물_조회_가능(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);

        //Act
        $response = $this->get(route('boards.show', ['board' => $board]));

        //Assert
        $response->assertStatus(200);
        $response->assertViewIs('board.show');
    }
    
    public function test_07_로그인_X_메이트_모집_게시물_편집_페이지_접근시_로그인_페이지로_이동(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);

        //Act
        $response = $this->get(route('boards.edit', ['board' => $board]));

        //Assert
        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
    }
    
    public function test_08_로그인_O_다른_유저의_메이트_모집_게시물_편집_페이지_접근_불가능(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        $otherUser = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);
        
        //Act
        $response = $this->actingAs($otherUser)->get(route('boards.edit', ['board' => $board]));

        //Assert
        $response->assertStatus(403);
    }
    
    public function test_09_로그인_O_본인_소유_메이트_모집_게시물_편집_페이지_접근_가능(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);

        //Act
        $response = $this->actingAs($user)->get(route('boards.edit', ['board' => $board]));

        //Assert
        $response->assertStatus(200);
        $response->assertViewIs('board.edit');
    }

    public function test_10_로그인_X_메이트_모집_게시물_수정시_로그인_페이지로_이동(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);

        //Act
        $response = $this->put(route('boards.update', ['board' => $board]), [
            'title' => '제목수정',
            'content' => '내용수정',
        ]);

        //Assert
        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
        $this->expectsDatabaseQueryCount(0);
    }
    
    public function test_11_로그인_O_다른_유저의_메이트_모집_게시물_수정_불가능(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        $otherUser = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);

        //Act
        $response = $this->actingAs($otherUser)->put(route('boards.update', ['board' => $board]), [
            'title' => '제목수정',
            'content' => '내용수정',
        ]);

        //Assert
        $response->assertStatus(403);
        $this->expectsDatabaseQueryCount(0);
    }
    
    public function test_12_로그인_O_본인_소유_메이트_모집_게시물_수정_가능(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);

        //Act
        $response = $this->actingAs($user)->put(route('boards.update', ['board' => $board]), [
            'title' => '제목수정',
            'content' => '내용수정',
        ]);

        //Assert
        $response->assertStatus(302);
        $response->assertRedirectToRoute('boards.show', ['board' => $board]);
        $this->assertDatabaseHas('boards', [
            'title' => '제목수정',
            'content' => '내용수정',
        ]);
    }

    public function test_13_로그인_X_메이트_모집_게시물_삭제_불가능(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);

        //Act
        $response = $this->delete(route('boards.destroy', ['board' => $board]));

        //Assert
        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
        $this->expectsDatabaseQueryCount(0);
    }
    
    public function test_13_로그인_O_다른_유저의_메이트_모집_게시물_삭제_불가능(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        $otherUser = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);

        //Act
        $response = $this->actingAs($otherUser)->delete(route('boards.destroy', ['board' => $board]));

        //Assert
        $response->assertStatus(403);
        $this->expectsDatabaseQueryCount(0);
    }
    
    public function test_13_로그인_O_본인_소유의_메이트_모집_게시물_삭제_가능(): void
    {
        //Create a gym using the factory
        $gym = Gym::factory()->create();
        //Create a user using the factory
        $user = User::factory()->create(['gym_id' => $gym->id]);
        //Create a board using the factory
        $board = Board::factory()->create(['user_id' => $user->id, 'gym_id' => $gym->id]);

        //Act
        $response = $this->actingAs($user)->delete(route('boards.destroy', ['board' => $board]));

        //Assert
        $response->assertStatus(302);
        $response->assertRedirectToRoute('boards.index');
        $this->assertModelMissing($board);
    }
}
