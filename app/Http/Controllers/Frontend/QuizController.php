<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return view('frontend.quizzes.show', compact('quiz'));
    }

    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $answers = $request->input('answers', []);
        $correctCount = 0;
        $totalQuestions = $quiz->questions->count();
        $results = [];

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? '';
            $isCorrect = strtolower($userAnswer) === strtolower($question->correct_answer);
            if ($isCorrect) $correctCount++;

            $results[] = [
                'question_id' => $question->id,
                'question' => $question->question_text,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'explanation' => $question->explanation,
            ];
        }

        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
        $passed = $score >= $quiz->passing_score;

        if ($request->user()) {
            QuizAttempt::create([
                'user_id' => $request->user()->id,
                'quiz_id' => $quiz->id,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctCount,
                'answers' => $answers,
                'passed' => $passed,
                'time_spent' => 0,
                'completed_at' => now(),
            ]);
        }

        return view('frontend.quizzes.result', compact(
            'quiz', 'results', 'score', 'correctCount', 'totalQuestions', 'passed'
        ));
    }
}
