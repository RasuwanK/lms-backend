<?php

namespace App\Http\Controllers;
use App\Models\Conversation; 


use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            'user_ids' => 'required|array|min:1',
        ]);

        $me = auth()->id();
        $ids = collect($request->user_ids)->push($me)->unique();

        $conversation = Conversation::create([
            'is_group' => $ids->count() > 2,
            'title' => $request->title ?? null,
        ]);
        $conversation->participants()->sync($ids);

        return response()->json(['conversation' => $conversation->load('participants')], 201);
    }

    public function list() {
        $me = auth()->id();
        $convs = Conversation::whereHas('participants', fn($q)=>$q->where('user_id',$me))
            ->with(['participants','messages'=>fn($q)=>$q->latest()->limit(1)])
            ->get();
        return response()->json(['conversations' => $convs]);
    }

    public function show(\App\Models\Conversation $conversation)
    {
        // Only participants can view the conversation
        abort_unless(
            $conversation->participants()->where('user_id', auth()->id())->exists(),
            403
        );

        return response()->json([
            'conversation' => $conversation->load([
                'participants:id,full_name,email', // load participants info
                'messages' => fn($q) => $q->latest()->limit(10)->with('sender:id,name,email') // recent messages
            ])
        ]);
    }

}

