<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementPublicController extends Controller
{
    public function show(Announcement $announcement)
    {
        abort_if(is_null($announcement->published_at) || $announcement->published_at->isFuture(), 404);
        return view('announcements.show', compact('announcement'));
    }
}

