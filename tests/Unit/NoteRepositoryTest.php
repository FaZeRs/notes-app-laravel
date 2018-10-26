<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Models\User;
use App\Repositories\Note\NoteRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var NoteRepositoryInterface
     */
    protected $noteRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->noteRepository = $this->app->make(NoteRepositoryInterface::class);
    }

    public function test_can_create_new_notes()
    {
        $user = factory(User::class)->create();
        $this->assertEquals(0, Note::count());
        $this->noteRepository->create([
            'user_id'   => $user->id,
            'body'      => 'Test body',
            'is_public' => true,
        ]);
        $this->assertEquals(1, Note::count());
    }

    public function test_can_update_existing_notes()
    {
        $note = factory(Note::class)->create();
        $this->noteRepository->update($note->id, [
            'body' => 'Updated body',
        ]);
        $this->assertEquals('Updated body', $note->fresh()->body);
    }

    public function test_can_delete_existing_notes()
    {
        $note = factory(Note::class)->create();
        $this->assertEquals(1, Note::count());
        $this->noteRepository->delete($note->id);
        $this->assertEquals(0, Note::count());
    }

    public function test_can_get_existing_notes()
    {
        factory(Note::class, 30)->create();
        $notes = $this->noteRepository->all();
        $this->assertEquals(30, $notes->count());
    }

    public function test_can_get_existing_note()
    {
        $note = factory(Note::class)->create();
        $repoNote = $this->noteRepository->find($note->id);
        $this->assertEquals($note->id, $repoNote->id);
        $this->assertEquals($note->user_id, $repoNote->user_id);
        $this->assertEquals($note->body, $repoNote->body);
        $this->assertEquals($note->is_public, $repoNote->is_public);
    }
}
