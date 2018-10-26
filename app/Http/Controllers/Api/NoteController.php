<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteNoteRequest;
use App\Http\Requests\ShowNoteRequest;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * @var Note
     */
    protected $model;

    /**
     * Instantiate a new controller instance.
     *
     * @param  Note $model
     * @return void
     */
    public function __construct(Note $model)
    {
        $this->model = $model;
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return NoteResource::collection($request->user()->notes);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPublic()
    {
        return NoteResource::collection($this->model->public()->get());
    }

    /**
     * @param  \App\Models\Note                   $note
     * @param  \App\Http\Requests\ShowNoteRequest $request
     * @return \App\Http\Resources\NoteResource
     */
    public function show(Note $note, ShowNoteRequest $request)
    {
        return new NoteResource($note);
    }

    /**
     * @param  \App\Models\Note                   $note
     * @param  \App\Http\Requests\ShowNoteRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function comments(Note $note, ShowNoteRequest $request)
    {
        return CommentResource::collection($note->comments);
    }

    /**
     * @param  StoreNoteRequest $request
     * @return \App\Http\Resources\NoteResource
     * @throws \Throwable
     */
    public function store(StoreNoteRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $note = $this->model->create($data);

        return new NoteResource($note);
    }

    /**
     * @param  \App\Models\Note                     $note
     * @param  \App\Http\Requests\UpdateNoteRequest $request
     * @return \App\Http\Resources\NoteResource
     * @throws \Throwable
     */
    public function update(Note $note, UpdateNoteRequest $request)
    {
        $data = $request->validated();
        $note->update($data);

        return new NoteResource($note);
    }

    /**
     * @param  \App\Models\Note                     $note
     * @param  \App\Http\Requests\DeleteNoteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy(Note $note, DeleteNoteRequest $request)
    {
        $note->delete();

        return response()->json(null, 204);
    }
}
