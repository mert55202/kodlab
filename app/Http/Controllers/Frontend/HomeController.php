<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Badge;
use App\Models\PaymentPlan;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        $courses = Course::where('is_published', true)->with('category')->orderBy('order')->get();
        $totalLessons = Lesson::where('is_published', true)->count();
        $totalCourses = $courses->count();
        $totalQuizzes = \App\Models\Quiz::where('is_active', true)->count();

        return view('frontend.home', compact(
            'categories', 'courses', 'totalLessons', 'totalCourses', 'totalQuizzes'
        ));
    }
}
