<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteCommentRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Note;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Note\NoteRepositoryInterface;

class CommentController extends Controller
{
    /**
     * @var \App\Repositories\Note\NoteRepositoryInterface
     */
    protected $notes;

    /**
     * @var \App\Repositories\Comment\CommentRepositoryInterface
     */
    protected $comments;

    /**
     * Instantiate a new controller instance.
     *
     * @param \App\Repositories\Note\NoteRepositoryInterface       $notes
     * @param \App\Repositories\Comment\CommentRepositoryInterface $comments
     */
    public function __construct(NoteRepositoryInterface $notes, CommentRepositoryInterface $comments)
    {
        $this->notes = $notes;
        $this->comments = $comments;
    }

    /**
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Note $note)
    {
        return CommentResource::collection($this->notes->getComments($note->id));
    }

    /**
     * @param \App\Models\Note     $note
     * @param  StoreCommentRequest $request
     * @return \App\Http\Resources\CommentResource
     * @throws \Throwable
     */
    public function store(Note $note, StoreCommentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['note_id'] = $note->id;
        $comment = $this->comments->create($data);

        return new CommentResource($comment);
    }

    /**
     * @param \App\Models\Note      $note
     * @param \App\Models\Comment   $comment
     * @param  UpdateCommentRequest $request
     * @return \App\Http\Resources\CommentResource
     * @throws \Throwable
     */
    public function update(Note $note, Comment $comment, UpdateCommentRequest $request)
    {
        $data = $request->validated();
        $this->comments->update($comment->id, $data);

        return new CommentResource($comment);
    }

    /**
     * @param \App\Models\Note                        $note
     * @param \App\Models\Comment                     $comment
     * @param \App\Http\Requests\DeleteCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy(Note $note, Comment $comment, DeleteCommentRequest $request)
    {
        $this->comments->delete($comment->id);

        return response()->json(null, 204);
    }
}