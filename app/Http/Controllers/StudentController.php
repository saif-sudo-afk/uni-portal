<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Schedule;
use App\Models\Upload;

class StudentController extends Controller
{
    public function dashboard()
    {
        $announcements = Announcement::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->limit(10)
            ->get();

        $recentUploads = Upload::latest()->limit(5)->get();
        $latestSchedules = Schedule::latest()->limit(5)->get();

        return view('student.dashboard', compact('announcements', 'recentUploads', 'latestSchedules'));
    }
}
