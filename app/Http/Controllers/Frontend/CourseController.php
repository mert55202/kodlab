<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;

class CourseController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount('courses')->orderBy('order')->get();
        $courses = Course::where('is_published', true)->with('category')->orderBy('order')->get();

        return view('frontend.courses.index', compact('categories', 'courses'));
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->with(['category', 'lessons' => function($q) {
                $q->where('is_published', true)->orderBy('order');
            }])
            ->firstOrFail();

        $lessons = $course->lessons;
        $totalDuration = $lessons->sum('estimated_minutes');

        return view('frontend.courses.show', compact('course', 'lessons', 'totalDuration'));
    }
}
