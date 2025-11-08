<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $semester = $request->input('semester');
        $major = $request->input('major');

        $schedules = Schedule::when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($semester, fn ($q) => $q->where('semester', $semester))
            ->when($major, fn ($q) => $q->where('major', $major))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $semesters = Schedule::select('semester')->distinct()->orderBy('semester')->pluck('semester');
        $majors = Schedule::select('major')->distinct()->orderBy('major')->pluck('major');
        $owners = User::whereIn('role', ['professor', 'admin'])->orderBy('name')->get();

        return view('admin.schedules.index', compact('schedules', 'semesters', 'majors', 'owners', 'search', 'semester', 'major'));
    }

    public function create()
    {
        $owners = User::whereIn('role', ['professor', 'admin'])->orderBy('name')->get();
        return view('admin.schedules.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => ['required', 'exists:users,id'],
            'semester' => ['required', 'string', 'max:100'],
            'major' => ['required', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['required', 'file', 'max:20480'],
        ]);

        $file = $request->file('file');
        $path = $file->store('schedules', 'public');

        Schedule::create([
            'user_id' => $validated['owner_id'],
            'semester' => $validated['semester'],
            'major' => $validated['major'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return redirect()->route('admin.schedules.index')->with('status', 'Schedule created');
    }

    public function edit(Schedule $schedule)
    {
        $owners = User::whereIn('role', ['professor', 'admin'])->orderBy('name')->get();
        return view('admin.schedules.edit', compact('schedule', 'owners'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'owner_id' => ['required', 'exists:users,id'],
            'semester' => ['required', 'string', 'max:100'],
            'major' => ['required', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'max:20480'],
        ]);

        $data = [
            'user_id' => $validated['owner_id'],
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

        return redirect()->route('admin.schedules.index')->with('status', 'Schedule updated');
    }

    public function destroy(Schedule $schedule)
    {
        Storage::disk('public')->delete($schedule->file_path);
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('status', 'Schedule deleted');
    }
}


