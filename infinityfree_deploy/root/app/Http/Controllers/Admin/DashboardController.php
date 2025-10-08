<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\File;
use App\Models\Link;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_files' => File::count(),
            'total_links' => Link::count(),
            'total_storage' => File::sum('file_size'),
            'most_downloaded' => File::orderBy('download_count', 'desc')->take(10)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
