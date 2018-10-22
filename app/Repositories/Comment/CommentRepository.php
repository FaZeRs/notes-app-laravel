<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\Repository;

class CommentRepository extends Repository implements CommentRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }
}