<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{
    /**
     * Display a listing of the notes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Auth::user()->notes()->orderBy('created_at', 'desc')->paginate(6);

        return view('notes.index', ['notes' => $notes]);
    }

    /**
     * Show the form for creating a new note.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created note in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $note = new Note();
        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->user_id = Auth::id();
        $note->save();

        return redirect()->route('notes.index')->with('status', 'Note created successfully.')->with('status-color', 'success');
    }

    /**
     * Display the specified note.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        Gate::authorize('view', $note);

        return view('notes.show', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified note.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        Gate::authorize('update', $note);

        return view('notes.edit', ['note' => $note]);
    }

    /**
     * Update the specified note in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        Gate::authorize('update', $note);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->save();

        return redirect()->route('notes.index')->with('status', 'Note updated successfully.')->with('status-color', 'primary');
    }

    /**
     * Remove the specified note from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        Gate::authorize('delete', $note);

        $note->delete();

        return redirect()->route('notes.index')->with('status', 'Note deleted successfully.')->with('status-color', 'danger');
    }
}
