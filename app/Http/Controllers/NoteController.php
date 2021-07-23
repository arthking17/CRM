<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Note;
use DateTime;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::all();
        return view('notes.list', [
            'notes' => $notes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'class' => 'required|integer|digits_between:1,1',
            'visibility' => 'required|integer|digits_between:1,1',
            'content' => 'required',
            'element' => 'required|integer|min:0|max:16',
            'element_id' => 'required|integer|digits_between:1,10',
        ]);
        $note = Note::create($data);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'note.create', 'element' => 13, 'element_id' => $note->id, 'source' => 'note.create']);
        return response()->json(['note' => $note, 'success' => 'Note added']);
    }

    /**
     * list Notes
     */
    public function listNotes($element_id)
    {
        $notes = Note::all()
            ->where('element_id', $element_id);
        return view('users/notes', compact('notes'))->render();
    }

    /**
     * Get note by id with json response.
     *
     * @param int $id
     * @param int $modal
     * @return \Illuminate\Http\Response
     */
    public function getNoteJsonById(int $id, int $modal)
    {
        $note = Note::all()
            ->find($id);
        if ($modal == 0)
            return view('notes/note-info', compact('note'))->render();
        if ($modal == 1)
            return response()->json($note);
        //return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'class' => 'required|integer|digits_between:1,1',
            'visibility' => 'required|integer|digits_between:1,1',
            'content' => 'required',
            'element' => 'required|integer|min:0|max:16',
            'element_id' => 'required|integer|digits_between:1,10',
        ]);
        $note = Note::find($request->id);
        $note->update($data);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'note.update', 'element' => 13, 'element_id' => $note->id, 'source' => 'note.update']);
        return response()->json(['note' => $note, 'success' => 'Note updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $note = Note::find($id);
        //$contact->status = 3;
        if ($note->delete()) {
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'notes.delete', 'element' => 13, 'element_id' => $id, 'source' => 'notes.delete, ' . $id]);
            return response()->json(['success' => 'This note has been Deleted !!!', 'contact' => $note]);
        } else
            return response()->json(['error' => 'Failed to delete this note !!!']);
    }
}
