<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function sources()
    {
        $lessonsBySource = Lesson::selectRaw('source_ref, count(*) as total')
            ->whereNotNull('source_ref')
            ->groupBy('source_ref')
            ->orderByDesc('total')
            ->get();

        $questionsBySource = Question::selectRaw('source_ref, count(*) as total')
            ->whereNotNull('source_ref')
            ->groupBy('source_ref')
            ->orderByDesc('total')
            ->get();

        return view('admin.reports.sources', compact('lessonsBySource', 'questionsBySource'));
    }
}
