<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\CodeExercise;

class LessonController extends Controller
{
    public function show($courseSlug, $lessonSlug)
    {
        $lesson = Lesson::where('slug', $lessonSlug)
            ->with(['course', 'quizzes.questions', 'codeExercises'])
            ->firstOrFail();

        $course = $lesson->course;
        $allLessons = $course->lessons()->where('is_published', true)->orderBy('order')->get();
        $currentIndex = $allLessons->search(function($l) use ($lesson) { return $l->id === $lesson->id; });
        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        return view('frontend.lessons.show', compact(
            'lesson', 'course', 'allLessons', 'prevLesson', 'nextLesson'
        ));
    }
}
