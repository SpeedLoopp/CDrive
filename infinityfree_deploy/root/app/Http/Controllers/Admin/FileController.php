<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::with('user')->latest()->paginate(20);
        return view('admin.files.index', compact('files'));
    }

    public function destroy(File $file)
    {
        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->back()->with('success', 'Dosya silindi!');
    }
}
