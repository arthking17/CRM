<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Contact;
use App\Models\Log;
use App\Models\Note;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //return $request;
        $data = $request->validate([
            'class' => 'required|integer|digits_between:1,1',
            'visibility' => 'required|integer|digits_between:1,1',
            'content' => 'required',
            'element' => 'required|integer|min:0|max:19',
            'element_id' => 'required|integer|digits_between:1,10',
        ]);
        $note = Note::create($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'note.create', 'element' => getElementByName('notes'), 'element_id' => $note->id, 'source' => 'note.create']);
        $notes = Note::All();
        $returnHTML = view('notes/datatable-notes', compact('notes'))->render();
        return response()->json(['success' => 'This note has been added !!!', 'html' => $returnHTML, 'note' => $note]);
    }

    /**
     * list Notes
     */
    public function listNotes($element_id, $element)
    {
        $notes = Note::all()
            ->where('element_id', $element_id)
            ->where('element', $element);
        return view('notes/notes-list-modal', compact('notes'))->render();
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
     * @param  int $element_id
     * @param  int $element
     * @return \Illuminate\Http\Response
     */
    public function show(int $element_id, int $element)
    {
        $notes = DB::table('notes')->where('element_id', $element_id)->where('element', $element)->get();
        $elementClass = $element;
        if ($element == 4) {
            $contact = Contact::find($element_id);
            return view('notes.notes-info-card', compact('notes', 'contact', 'elementClass'))->render();
        } else if ($element == 17) {
            $user = User::find($element_id);
            return view('notes.notes-info-card', compact('notes', 'user', 'elementClass'))->render();
        }else if($element == 2){
            $element = Communication::find($element_id);
            return view('notes.notes-info-card', compact('notes', 'element', 'elementClass'))->render();
        }
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
            'id' => 'required',
            'class' => 'required|integer|digits_between:1,1',
            'visibility' => 'required|integer|digits_between:1,1',
            'content' => 'required',
            'element' => 'required|integer|min:0|max:19',
            'element_id' => 'required|integer|digits_between:1,10',
        ]);
        $note = Note::find($request->id);
        $note->update($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'note.update', 'element' => getElementByName('notes'), 'element_id' => $note->id, 'source' => 'note.update']);
        $notes = Note::All();
        $returnHTML = view('notes/datatable-notes', compact('notes'))->render();
        return response()->json(['success' => 'This note has been updated !!!', 'html' => $returnHTML, 'note' => $note]);
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
        if ($note->delete()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'notes.delete', 'element' => getElementByName('notes'), 'element_id' => $id, 'source' => 'notes.delete, ' . $id]);
            $notes = Note::All();
            $returnHTML = view('notes/datatable-notes', compact('notes'))->render();
            return response()->json(['success' => 'This note has been Deleted !!!', 'html' => $returnHTML, 'note' => $note]);
        } else
            return response()->json(['error' => 'Failed to delete this note !!!']);
    }
}
