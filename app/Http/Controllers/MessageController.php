<?php

namespace App\Http\Controllers;
use App\Models\Conversation; 


use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function list(Conversation $conversation) {
        abort_unless($conversation->participants()->where('user_id', auth()->id())->exists(), 403);

        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get();
        return response()->json(['messages' => $messages]);
    }

    public function send(Request $request, Conversation $conversation) {
        abort_unless($conversation->participants()->where('user_id', auth()->id())->exists(), 403);

        $request->validate(['body' => 'required|string']);

        $msg = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return response()->json(['message' => $msg->load('sender')], 201);
    }
}

