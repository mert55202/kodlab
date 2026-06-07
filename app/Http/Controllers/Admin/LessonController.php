<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index(Request $request)
    {
        $query = Lesson::with('course');
        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }
        $lessons = $query->orderBy('order')->get();
        $courses = Course::where('is_published', true)->orderBy('title')->get();
        return view('admin.lessons.index', compact('lessons', 'courses'));
    }

    public function create()
    {
        $courses = Course::where('is_published', true)->orderBy('title')->get();
        return view('admin.lessons.form', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:lessons',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string|max:500',
            'code_example' => 'nullable|string',
            'estimated_minutes' => 'nullable|integer|min:1',
            'order' => 'nullable|integer',
            'source_ref' => 'nullable|string|max:255',
            'source_note' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        Lesson::create($data);
        return redirect()->route('admin.lessons.index')->with('success', 'Ders oluşturuldu.');
    }

    public function edit(Lesson $lesson)
    {
        $courses = Course::where('is_published', true)->orderBy('title')->get();
        return view('admin.lessons.form', compact('lesson', 'courses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:lessons,slug,' . $lesson->id,
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string|max:500',
            'code_example' => 'nullable|string',
            'estimated_minutes' => 'nullable|integer|min:1',
            'order' => 'nullable|integer',
            'source_ref' => 'nullable|string|max:255',
            'source_note' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        $lesson->update($data);
        return redirect()->route('admin.lessons.index')->with('success', 'Ders güncellendi.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->quizzes()->delete();
        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Ders silindi.');
    }
}
