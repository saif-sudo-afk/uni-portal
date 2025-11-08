<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $semester = $request->input('semester');
        $major = $request->input('major');

        $schedules = Schedule::where('user_id', auth()->id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($semester, fn ($q) => $q->where('semester', $semester))
            ->when($major, fn ($q) => $q->where('major', $major))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $semesters = Schedule::where('user_id', auth()->id())->select('semester')->distinct()->pluck('semester');
        $majors = Schedule::where('user_id', auth()->id())->select('major')->distinct()->pluck('major');

        return view('professor.schedules.index', compact('schedules', 'search', 'semester', 'major', 'semesters', 'majors'));
    }

    public function create()
    {
        return view('professor.schedules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'semester' => ['required', 'string', 'max:100'],
            'major' => ['required', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['required', 'file', 'max:20480'],
        ]);

        $file = $request->file('file');
        $path = $file->store('schedules', 'public');

        Schedule::create([
            'user_id' => $request->user()->id,
            'semester' => $validated['semester'],
            'major' => $validated['major'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return redirect()->route('professor.schedules.index')->with('status', 'Schedule uploaded');
    }

    public function edit(Schedule $schedule)
    {
        abort_unless($schedule->user_id === auth()->id(), 403);
        return view('professor.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        abort_unless($schedule->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'semester' => ['required', 'string', 'max:100'],
            'major' => ['required', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'max:20480'],
        ]);

        $data = [
            'semester' => $validated['semester'],
            'major' => $validated['major'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ];

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($schedule->file_path);
            $file = $request->file('file');
            $data['file_path'] = $file->store('schedules', 'public');
            $data['original_name'] = $file->getClientOriginalName();
        }

        $schedule->update($data);

        return redirect()->route('professor.schedules.index')->with('status', 'Schedule updated');
    }

    public function destroy(Schedule $schedule)
    {
        abort_unless($schedule->user_id === auth()->id(), 403);
        Storage::disk('public')->delete($schedule->file_path);
        $schedule->delete();

        return redirect()->route('professor.schedules.index')->with('status', 'Schedule deleted');
    }
}