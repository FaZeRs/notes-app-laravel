<?php

namespace Tests\Feature;

use App\Models\Note;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_create_a_note()
    {
        $this->login();
        $data = [
            'body'      => $this->faker->sentence,
            'is_public' => $this->faker->boolean($chanceOfGettingTrue = 50),
        ];
        $response = $this->postJson(route('notes.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'is_public',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_can_edit_a_note()
    {
        $user = $this->login();
        $note = factory(Note::class)->create(['user_id' => $user->id]);
        $data = [
            'body' => $this->faker->sentence,
        ];
        $response = $this->putJson(route('notes.update', $note), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'is_public',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_can_delete_a_note()
    {
        $user = $this->login();
        $note = factory(Note::class)->create(['user_id' => $user->id]);
        $response = $this->deleteJson(route('notes.destroy', $note));
        $response->assertSuccessful();
    }

    public function test_get_user_notes()
    {
        $user = $this->login();
        factory(Note::class, 10)->create(['user_id' => $user->id]);
        $response = $this->getJson(route('notes.index'));
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'body',
                    'is_public',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_get_note()
    {
        $user = $this->login();
        $note = factory(Note::class)->create(['user_id' => $user->id]);
        $response = $this->getJson(route('notes.show', $note));
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'is_public',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_get_public_notes()
    {
        $this->login();
        factory(Note::class, 5)->create(['is_public' => true]);
        $response = $this->getJson(route('notes.public'));
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'body',
                    'is_public',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }
}
