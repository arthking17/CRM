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
        //
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
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
    }
}
