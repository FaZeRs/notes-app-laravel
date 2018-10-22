<?php

namespace App\Repositories\Note;

use App\Repositories\RepositoryInterface;

interface NoteRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all user notes in the database.
     *
     * @param  mixed $user_id
     * @param  array  $columns
     * @return \Illuminate\Support\Collection
     */
    public function getUserNotes($user_id, array $columns = ['*']);

    /**
     * Get all public notes in the database.
     *
     * @param  array  $columns
     * @return \Illuminate\Support\Collection
     */
    public function getPublic(array $columns = ['*']);

    /**
     * Get all notes comments in the database.
     *
     * @param  mixed $id
     * @param  array  $columns
     * @return \Illuminate\Support\Collection
     */
    public function getComments($id, array $columns = ['*']);
}