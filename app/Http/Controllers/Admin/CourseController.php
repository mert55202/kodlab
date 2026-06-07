<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        $courses = Course::with('category')->orderBy('order')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        return view('admin.courses.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        Course::create($data);
        return redirect()->route('admin.courses.index')->with('success', 'Kurs oluşturuldu.');
    }

    public function edit(Course $course)
    {
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        return view('admin.courses.form', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses,slug,' . $course->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        $course->update($data);
        return redirect()->route('admin.courses.index')->with('success', 'Kurs güncellendi.');
    }

    public function destroy(Course $course)
    {
        $course->lessons()->delete();
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Kurs ve dersleri silindi.');
    }
}
