<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $uploads = Upload::when($search, function ($query) use ($search) {
                $query->where('original_name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('student.uploads.index', compact('uploads', 'search'));
    }

    public function download(Upload $upload)
    {
        return Storage::disk('public')->download($upload->path, $upload->original_name);
    }
}
