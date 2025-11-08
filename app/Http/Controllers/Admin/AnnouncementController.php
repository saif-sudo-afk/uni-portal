<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $announcements = Announcement::when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.announcements.index', compact('announcements', 'search'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'body' => ['required','string'],
            'published_at' => ['nullable','date'],
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['published_at'] = $request->filled('published_at')
            ? Carbon::parse($request->input('published_at'))
            : now();

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement created');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'body' => ['required','string'],
            'published_at' => ['nullable','date'],
        ]);

        if ($request->filled('published_at')) {
            $validated['published_at'] = Carbon::parse($request->input('published_at'));
        }

        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement updated');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement deleted');
    }
}

