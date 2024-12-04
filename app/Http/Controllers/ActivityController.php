<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Question;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function addQuestion(Request $request, $quizId)
    {
        $quiz = Activity::where('id', $quizId)->where('type', 'quiz')->firstOrFail();

        // Validate incoming request
        $request->validate([
            'questions' => 'required|array',
            'questions.*.question_number' => 'required|integer',
            'questions.*.question' => 'required|string',
            'questions.*.question_type' => 'required|in:single_answer,multiple_choice',
            'questions.*.answer' => 'required|string',
            'questions.*.options' => 'nullable|array',
        ]);

        // Check the current count of questions
        $currentQuestionCount = $quiz->questions()->count();
        $newQuestionCount = count($request->questions);
        $maxQuestions = $quiz->question_count;

        // Validate if the new questions exceed the limit
        if (($currentQuestionCount + $newQuestionCount) > $maxQuestions) {
            return response()->json([
                'message' => 'Cannot add more questions. Maximum question count exceeded.',
            ], 422);
        }

        // Add the questions to the quiz
        foreach ($request->questions as $questionData) {
            $quiz->questions()->create($questionData);
        }

        return response()->json(['message' => 'Questions added successfully.']);
    }

    public function getQuestions($quizid)
    {
        $quiz = Activity::where('id',$quizid)
            ->where('type', 'quiz')
            ->with('questions')
            ->firstOrFail();

        return response()->json($quiz->questions);
    }

    public function updateQuestion(Request $request, $quizId, $questionId)
    {
        // Validate input
        $request->validate([
            'question_number' => 'integer',
            'question' => 'string',
            'question_type' => 'in:single_answer,multiple_choice',
            'answer' => 'string|nullable',
            'options' => 'array|nullable',
        ]);

        // Ensure the question belongs to the specified quiz
        $question = Question::where('id', $questionId)
            ->where('quiz_id', $quizId)
            ->firstOrFail();

        // Update the question
        $question->update($request->all());

        return response()->json(['message' => 'Question updated successfully.', 'question' => $question]);
    }

    public function deleteAllQuestion($quizid)
    {
        $quiz = Activity::where('id',$quizid)
            ->where('type', 'quiz')
            ->with('questions')
            ->firstOrFail();
        $quiz->questions()->delete();
        return response()->json(['message'=> 'Questions deleted successfully.']);
    }

    public function deleteSpecificQuestion($quizId, $questionId)
    {
        $question = Question::where('id',$questionId)
                    ->where('quiz_id', $quizId)
                    ->firstOrFail();
        $question->delete();
        return response()->json(['message' => 'Question deleted successfully.']);
    }

}
