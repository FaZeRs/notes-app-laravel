<?php

namespace App\Repositories\Note;

use App\Models\Note;
use App\Repositories\Repository;

class NoteRepository extends Repository implements NoteRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Note::class;
    }

    /**
     * Get all user notes in the database.
     *
     * @param  mixed $user_id
     * @param  array $columns
     * @return \Illuminate\Support\Collection
     */
    public function getUserNotes($user_id, array $columns = ['*'])
    {
        return $this->newQuery()->where('user_id', $user_id)->with('comments')->get($columns);
    }

    /**
     * Get all public notes in the database.
     *
     * @param  array $columns
     * @return \Illuminate\Support\Collection
     */
    public function getPublic(array $columns = ['*'])
    {
        return $this->newQuery()->where('is_public', true)->with('comments')->get($columns);
    }

    /**
     * Get all notes comments in the database.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Illuminate\Support\Collection
     */
    public function getComments($id, array $columns = ['*'])
    {
        return $this->findOrFail($id)->comments()->get($columns);
    }
}