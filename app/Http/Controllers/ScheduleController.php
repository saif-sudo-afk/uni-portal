<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $semester = $request->input('semester');
        $major = $request->input('major');

        $schedules = Schedule::when($semester, fn ($q) => $q->where('semester', $semester))
            ->when($major, fn ($q) => $q->where('major', $major))
            ->latest('semester')
            ->paginate(12)
            ->withQueryString();

        $semesters = Schedule::select('semester')->distinct()->orderBy('semester')->pluck('semester');
        $majors = Schedule::select('major')->distinct()->orderBy('major')->pluck('major');

        return view('schedule.index', compact('schedules', 'semester', 'major', 'semesters', 'majors'));
    }

    public function view(Schedule $schedule)
    {
        abort_unless(Storage::disk('public')->exists($schedule->file_path), 404);

        return Storage::disk('public')->response($schedule->file_path, $schedule->original_name, [
            'Content-Disposition' => 'inline; filename="'.$schedule->original_name.'"',
        ]);
    }

    public function download(Schedule $schedule)
    {
        return Storage::disk('public')->download($schedule->file_path, $schedule->original_name);
    }
}
