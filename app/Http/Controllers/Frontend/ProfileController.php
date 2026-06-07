<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LessonProgress;
use App\Models\QuizAttempt;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $completedLessons = LessonProgress::where('user_id', $user->id)->where('completed', true)->count();
        $quizAttempts = QuizAttempt::where('user_id', $user->id)->count();
        $avgScore = QuizAttempt::where('user_id', $user->id)->avg('score') ?? 0;
        $badges = $user->badges()->get();
        $bookmarks = $user->bookmarks()->with('lesson')->latest()->take(5)->get();

        return view('frontend.profile.dashboard', compact(
            'user', 'completedLessons', 'quizAttempts', 'avgScore', 'badges', 'bookmarks'
        ));
    }

    public function edit()
    {
        return view('frontend.profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'github' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'theme' => 'nullable|in:light,dark',
        ]);

        $user->update($data);
        return redirect()->route('profile.edit')->with('success', 'Profil güncellendi.');
    }

    public function bookmarks()
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())
            ->with('lesson.course')
            ->latest()
            ->paginate(20);

        return view('frontend.profile.bookmarks', compact('bookmarks'));
    }

    public function toggleBookmark($lessonId)
    {
        $existing = Bookmark::where('user_id', auth()->id())
            ->where('lesson_id', $lessonId)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Yer imi kaldırıldı.');
        }

        Bookmark::create([
            'user_id' => auth()->id(),
            'lesson_id' => $lessonId,
        ]);

        return back()->with('success', 'Yer imi eklendi.');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
