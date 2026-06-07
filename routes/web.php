<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CourseController;
use App\Http\Controllers\Frontend\LessonController;
use App\Http\Controllers\Frontend\QuizController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/arama', function () {
    $query = request('q');
    $lessons = \App\Models\Lesson::where('is_published', true)
        ->where(function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
        })
        ->with('course')
        ->get();
    return view('frontend.search', compact('query', 'lessons'));
})->name('search');

// Courses & Lessons
Route::get('/kurslar', [CourseController::class, 'index'])->name('courses.index');
Route::get('/kurs/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/kurs/{courseSlug}/{lessonSlug}', [LessonController::class, 'show'])->name('lessons.show');

// Quizzes
Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quizzes.show');
Route::post('/quiz/{id}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');

// Pricing plans
Route::get('/paketler', function () {
    $plans = \App\Models\PaymentPlan::where('is_active', true)->orderBy('order')->get();
    return view('frontend.plans', compact('plans'));
})->name('plans');

// Payment webhooks (no auth)
Route::post('webhook/stripe', [\App\Http\Controllers\WebhookController::class, 'stripe'])->name('webhook.stripe');
Route::post('webhook/iyzico', [\App\Http\Controllers\WebhookController::class, 'iyzico'])->name('webhook.iyzico');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/panel', [FrontendProfileController::class, 'dashboard'])->name('profile.dashboard');
    Route::get('/profil', [FrontendProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [FrontendProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [FrontendProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/yer-imleri', [FrontendProfileController::class, 'bookmarks'])->name('profile.bookmarks');
    Route::post('/yer-imleri/{lessonId}', [FrontendProfileController::class, 'toggleBookmark'])->name('profile.bookmark.toggle');
    Route::get('/aboneliklerim', [\App\Http\Controllers\Frontend\PaymentController::class, 'mySubscriptions'])->name('payment.my-subscriptions');
    Route::post('/abonelik/{id}/iptal', [\App\Http\Controllers\Frontend\PaymentController::class, 'cancelSubscription'])->name('payment.cancel');
    Route::post('/tema', function (\Illuminate\Http\Request $request) {
        $theme = $request->validate(['theme' => 'required|in:light,dark'])['theme'];
        $request->user()->update(['theme' => $theme]);
        return response()->json(['ok' => true]);
    })->name('theme.toggle');

    // Payment
    Route::get('/odeme/{planId}', [\App\Http\Controllers\Frontend\PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/odeme/{planId}/stripe', [\App\Http\Controllers\Frontend\PaymentController::class, 'payWithStripe'])->name('payment.stripe');
    Route::post('/odeme/{planId}/iyzico', [\App\Http\Controllers\Frontend\PaymentController::class, 'payWithIyzico'])->name('payment.iyzico');
    Route::get('/odeme-sonuc/{gateway}', [\App\Http\Controllers\Frontend\PaymentController::class, 'callback'])->name('payment.callback');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::resource('lessons', \App\Http\Controllers\Admin\LessonController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['create', 'store']);
    Route::get('reports/sources', [\App\Http\Controllers\Admin\ReportController::class, 'sources'])->name('reports.sources');
    Route::get('ads', [\App\Http\Controllers\Admin\AdSettingController::class, 'index'])->name('ads.index');
    Route::post('ads', [\App\Http\Controllers\Admin\AdSettingController::class, 'update'])->name('ads.update');
    Route::get('payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/subscriptions', [\App\Http\Controllers\Admin\PaymentController::class, 'subscriptions'])->name('payments.subscriptions');
});

require __DIR__.'/auth.php';
