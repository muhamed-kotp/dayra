<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('users')->get();
        return response()->json($notes);
    }

    /**
     * Store a newly created Note in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }

        Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id'=>Auth::user()->id,
        ]);

        $success= 'Note Created sucssefully' ;
        return response()->json($success);

    }

    /**
     * Display the specified Note.
     */
    public function show(string $id)
    {
        $note = Note::findOrFail($id);
        return response()->json($note);
    }

    /**
     * Update the specified Note in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }

        $note = Note::findOrFail($id);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
            'user_id'=>Auth::user()->id,
        ]);

        $success= 'Note Updated sucssefully' ;
        return response()->json($success);

    }

    /**
     * Remove the specified Note from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        $success= 'The Note is Deleated sucssefully' ;
        return response()->json($success);
    }
}
