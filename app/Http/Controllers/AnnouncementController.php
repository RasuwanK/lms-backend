<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function addAnswer(Request $request, $announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);

        $request->validate([
            'description' => 'required|string',
            'user_id' => 'required|exists:portal_users,id', // Ensure the user exists
        ]);

        $answer = $announcement->answers()->create([
            'description' => $request->description,
            'user_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Answer added successfully.', 'answer' => $answer], 201);
    }

    public function getAnswers($announcementId)
    {
        $announcement = Announcement::with('answers.user')->findOrFail($announcementId);

        return response()->json($announcement->answers);
    }

//    public function updateAnswer(Request $request, $answerId)
//    {
//        $answer = Answer::findOrFail($answerId);
//
//        $request->validate([
//            'description' => 'required|string',
//        ]);
//
//        $answer->update($request->only('description'));
//
//        return response()->json(['message' => 'Answer updated successfully.', 'answer' => $answer]);
//    }


    public function updateAnswer(Request $request, $announcementId, $answerId)
    {
        // Find the answer and ensure it belongs to the announcement
        $answer = Answer::where('id', $answerId)
            ->where('announcement_id', $announcementId)
            ->firstOrFail();

        // Check if the authenticated user is the owner of the answer
        if ($answer->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate the request data
        $request->validate([
            'description' => 'required|string',
        ]);

        // Update the answer
        $answer->update([
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Answer updated successfully.', 'answer' => $answer]);
    }


//    public function deleteAnswer($answerId)
//    {
//        $answer = Answer::findOrFail($answerId);
//
//        $answer->delete();
//
//        return response()->json(['message' => 'Answer deleted successfully.']);
//    }

    public function deleteAnswer($announcementId, $answerId)
    {
        // Find the answer and ensure it belongs to the announcement
        $answer = Answer::where('id', $answerId)
            ->where('announcement_id', $announcementId)
            ->firstOrFail();

        // Check if the authenticated user is the owner of the answer
        if ($answer->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete the answer
        $answer->delete();

        return response()->json(['message' => 'Answer deleted successfully.']);
    }

}
