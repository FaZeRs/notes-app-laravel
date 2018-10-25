<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Note;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_create_a_comment()
    {
        $user = $this->login();
        $note = factory(Note::class)->create(['user_id' => $user->id]);
        $data = [
            'body' => $this->faker->sentence,
        ];
        $response = $this->postJson(route('comments.store', $note), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_can_edit_a_comment()
    {
        $user = $this->login();
        $note = factory(Note::class)->create(['user_id' => $user->id]);
        $comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'note_id' => $note->id,
        ]);
        $data = [
            'body' => $this->faker->sentence,
        ];
        $response = $this->putJson(route('comments.update', ['note' => $note, 'comment' => $comment]), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_can_delete_a_comment()
    {
        $user = $this->login();
        $note = factory(Note::class)->create(['user_id' => $user->id]);
        $comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'note_id' => $note->id,
        ]);
        $response = $this->deleteJson(route('comments.destroy', ['note' => $note, 'comment' => $comment]));
        $response->assertSuccessful();
    }

    public function test_get_note_comments()
    {
        $user = $this->login();
        $note = factory(Note::class)->create(['user_id' => $user->id]);
        factory(Comment::class, 20)->create([
            'user_id' => $user->id,
            'note_id' => $note->id,
        ]);
        $response = $this->getJson(route('comments.index', $note));
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'body',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }
}
