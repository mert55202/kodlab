<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizAttempt;
use App\Models\PaymentPlan;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function dashboard()
    {
        $totalCategories = Category::count();
        $totalCourses = Course::count();
        $totalLessons = Lesson::count();
        $totalQuizzes = Quiz::count();
        $totalQuestions = \App\Models\Question::count();
        $totalUsers = User::count();
        $totalAttempts = QuizAttempt::count();
        $recentUsers = User::latest()->take(5)->get();
        $recentAttempts = QuizAttempt::with('user', 'quiz')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCategories', 'totalCourses', 'totalLessons', 'totalQuizzes',
            'totalQuestions', 'totalUsers', 'totalAttempts', 'recentUsers', 'recentAttempts'
        ));
    }
}
