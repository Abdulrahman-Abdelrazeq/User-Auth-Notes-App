<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class NoteController extends Controller
{
    /**
     * Display a listing of the user's notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notes = Auth::user()->notes()->orderBy('created_at', 'desc')->paginate(6);
        return response()->json($notes);
    }

    /**
     * Store a newly created note in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note = new Note([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        $note->save();

        return response()->json([
            'message' => 'Note created successfully',
            'note' => $note
        ], 201);
    }

    /**
     * Display the specified note.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Note $note)
    {
        Gate::authorize('view', $note);

        return response()->json($note);
    }

    /**
     * Update the specified note in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Note $note)
    {
        Gate::authorize('update', $note);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->save();

        return response()->json([
            'message' => 'Note updated successfully',
            'note' => $note
        ]);
    }

    /**
     * Remove the specified note from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Note $note)
    {
        Gate::authorize('delete', $note);

        $note->delete();

        return response()->json([
            'message' => 'Note deleted successfully'
        ]);
    }
}
