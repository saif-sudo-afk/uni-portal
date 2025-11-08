<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('q');

        $announcements = Announcement::where('user_id', auth()->id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('professor.announcements.index', compact('announcements', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('professor.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'body' => ['required','string'],
        ]);

        $validated['user_id'] = $request->user()->id;
        // Auto-publish immediately on creation
        $validated['published_at'] = now();

        Announcement::create($validated);

        return redirect()->route('professor.announcements.index')
            ->with('status', 'Announcement created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        abort_unless($announcement->user_id === auth()->id(), 403);
        return view('professor.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        abort_unless($announcement->user_id === auth()->id(), 403);
        return view('professor.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        abort_unless($announcement->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'body' => ['required','string'],
            'published_at' => ['nullable','date'],
        ]);

        if ($request->filled('published_at')) {
            $validated['published_at'] = Carbon::parse($request->input('published_at'));
        }

        $announcement->update($validated);

        return redirect()->route('professor.announcements.index')
            ->with('status', 'Announcement updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        abort_unless($announcement->user_id === auth()->id(), 403);
        $announcement->delete();

        return redirect()->route('professor.announcements.index')
            ->with('status', 'Announcement deleted');
    }
}
