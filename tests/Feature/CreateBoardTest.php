<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateBoardTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_valid_board(): void
    {
        $data = ['title' => 'Some new board'];
        $url = route('boards.store');
        $response = $this->postJson($url, $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }
}
