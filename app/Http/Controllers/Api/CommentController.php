<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteCommentRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Note;

class CommentController extends Controller
{
    /**
     * @var Comment
     */
    protected $model;

    /**
     * Instantiate a new controller instance.
     *
     * @param  Comment $model
     * @return void
     */
    public function __construct(Comment $model)
    {
        $this->model = $model;
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
        $comment = $this->model->create($data);

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
        $comment->update($data);

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
        $comment->delete();

        return response()->json(null, 204);
    }
}
