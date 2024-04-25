<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Board;

class UpdateBoardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_response_status_400_if_invalid_stage(): void
    {
        Board::factory(10)->create();

        $some_invalid_stages = ['-1', '0', '4', '5', 'string', '1.2'];
        foreach ($some_invalid_stages as $stage) {
            $data = ['stage' => $stage];
            $url = route('boards.update', ["board" => "1"]);
            $response = $this->putJson($url, $data);

            $response->assertStatus(400);
        }
    }

    public function test_response_status_200_if_valid_stage(): void
    {
        Board::factory(10)->create();

        $valid_stages = ['1', '2', '3'];
        foreach ($valid_stages as $stage) {
            $data = ['stage' => $stage];
            $url = route('boards.update', ["board" => "1"]);
            $response = $this->putJson($url, $data);

            $response->assertStatus(200);
            $response->assertJsonFragment(["stage" => $stage]);
            $response->assertJsonStructure(["id", "title", "stage"]);
        }
    }
}
