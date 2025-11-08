<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()) {
            $user = $request->user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'professor') {
                return redirect()->route('professor.dashboard');
            }
            if ($user->role === 'student') {
                return redirect()->route('student.dashboard');
            }
            return redirect()->route('dashboard');
        }

        $heroTitle = config('marketing.hero_title', 'Study smarter. Learn faster. Stay connected.');
        $heroSubtitle = config('marketing.hero_subtitle', 'A single portal for students and professors — dashboards, announcements, and resources that keep your academic life clear and organized.');
        $features = config('marketing.features', [
            ['title' => 'Role-based Dashboards', 'desc' => 'Clean layouts for professors and students with focused actions.'],
            ['title' => 'Announcements', 'desc' => 'Professors post updates; students see the latest instantly.'],
            ['title' => 'File Sharing', 'desc' => 'Upload and download course materials securely.'],
        ]);
        $contactEmail = config('marketing.contact_email', 'admin@university.edu');

        $latest = Announcement::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->limit(3)
            ->get(['id','title','published_at']);

        return view('home', [
            'hero_title' => $heroTitle,
            'hero_subtitle' => $heroSubtitle,
            'features' => $features,
            'contact_email' => $contactEmail,
            'latest_announcements' => $latest,
        ]);
    }
}
