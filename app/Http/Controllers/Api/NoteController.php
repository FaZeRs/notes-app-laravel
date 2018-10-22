<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DeleteNoteRequest;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Repositories\Note\NoteRepositoryInterface;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * @var NoteRepositoryInterface
     */
    protected $notes;

    /**
     * Instantiate a new controller instance.
     * @param NoteRepositoryInterface $notes
     * @return void
     */
    public function __construct(NoteRepositoryInterface $notes)
    {
        $this->notes = $notes;
    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return NoteResource::collection($this->notes->getUserNotes($request->user()->id));
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPublic()
    {
        return NoteResource::collection($this->notes->getPublic());
    }

    /**
     * @param  \App\Models\Note $note
     * @return \App\Http\Resources\NoteResource
     */
    public function show(Note $note)
    {
        return new NoteResource($this->notes->findOrFail($note->id));
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
        $note = $this->notes->create($data);

        return new NoteResource($note);
    }

    /**
     * @param \App\Models\Note $note
     * @param  UpdateNoteRequest $request
     * @return \App\Http\Resources\NoteResource
     * @throws \Throwable
     */
    public function update(Note $note, UpdateNoteRequest $request)
    {
        $data = $request->validated();
        $note = $this->notes->update($note->id, $data);

        return new NoteResource($note);
    }

    /**
     * @param \App\Models\Note $note
     * @param \App\Http\Requests\DeleteNoteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy(Note $note, DeleteNoteRequest $request)
    {
        $this->notes->delete($note->id);

        return response()->json(null, 204);
    }
}
