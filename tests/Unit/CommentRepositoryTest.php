<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\User;
use Tests\TestCase;
use App\Models\Note;
use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->commentRepository = $this->app->make(CommentRepositoryInterface::class);
    }

    public function test_can_create_new_comments()
    {
        $user = factory(User::class)->create();
        $note = factory(Note::class)->create();
        $this->assertEquals(0, Comment::count());
        $this->commentRepository->create([
            'user_id' => $user->id,
            'note_id' => $note->id,
            'body'    => 'Test body',
        ]);
        $this->assertEquals(1, Comment::count());
    }

    public function test_can_update_existing_comments()
    {
        $comment = factory(Comment::class)->create();
        $this->commentRepository->update($comment->id, [
            'body' => 'Updated body',
        ]);
        $this->assertEquals('Updated body', $comment->fresh()->body);
    }

    public function test_can_delete_existing_comments()
    {
        $comment = factory(Comment::class)->create();
        $this->assertEquals(1, Comment::count());
        $this->commentRepository->delete($comment->id);
        $this->assertEquals(0, Comment::count());
    }

    public function test_can_get_existing_comments()
    {
        factory(Comment::class, 30)->create();
        $comments = $this->commentRepository->all();
        $this->assertEquals(30, $comments->count());
    }

    public function test_can_get_existing_comment()
    {
        $comment = factory(Comment::class)->create();
        $repoComment = $this->commentRepository->find($comment->id);
        $this->assertEquals($comment->id, $repoComment->id);
        $this->assertEquals($comment->user_id, $repoComment->user_id);
        $this->assertEquals($comment->note_id, $repoComment->note_id);
        $this->assertEquals($comment->body, $repoComment->body);
    }
}