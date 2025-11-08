<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Schedule;
use App\Models\Upload;

class ProfessorController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();
        $stats = [
            'announcements' => Announcement::where('user_id', $userId)->count(),
            'uploads' => Upload::where('user_id', $userId)->count(),
            'schedules' => Schedule::where('user_id', $userId)->count(),
        ];

        $recentAnnouncements = Announcement::where('user_id', $userId)
            ->latest('published_at')
            ->limit(5)
            ->get();

        $recentUploads = Upload::where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        $recentSchedules = Schedule::where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        return view('professor.dashboard', compact('stats', 'recentAnnouncements', 'recentUploads', 'recentSchedules'));
    }
}
