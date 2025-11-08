<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Schedule;
use App\Models\Upload;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'students' => User::where('role', 'student')->count(),
            'professors' => User::where('role', 'professor')->count(),
            'announcements' => Announcement::count(),
            'uploads' => Upload::count(),
            'schedules' => Schedule::count(),
        ];

        $recentSchedules = Schedule::latest()->limit(5)->get();
        $recentAnnouncements = Announcement::latest('published_at')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentSchedules', 'recentAnnouncements'));
    }
}

