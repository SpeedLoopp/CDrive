<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function index()
    {
        $files = auth()->user()->files()->latest()->paginate(20);
        return view('dashboard.files.index', compact('files'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:' . (config('app.upload_max_size') / 1024),
            'folder' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        
        // Dosya uzantısı kontrolü
        $allowedExtensions = explode(',', config('app.allowed_extensions'));
        $extension = strtolower($file->getClientOriginalExtension());
        
        if (!in_array($extension, $allowedExtensions)) {
            return redirect()->back()->with('error', 'Bu dosya türüne izin verilmiyor!');
        }

        // Güvenli dosya adı oluştur
        $fileName = Str::random(40) . '.' . $extension;
        $path = $file->storeAs('uploads/' . auth()->id(), $fileName, 'public');

        // XSS koruması: Dosya adını temizle
        $originalName = strip_tags($file->getClientOriginalName());
        $folderName = $request->folder ? strip_tags($request->folder) : null;

        $fileRecord = File::create([
            'user_id' => auth()->id(),
            'file_name' => $fileName,
            'original_name' => $originalName,
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'folder' => $folderName,
        ]);

        return redirect()->back()->with('success', 'Dosya başarıyla yüklendi!');
    }

    public function download(File $file)
    {
        if ($file->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $file->increment('download_count');
        return Storage::disk('public')->download($file->file_path, $file->original_name);
    }

    public function destroy(File $file)
    {
        if ($file->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->back()->with('success', 'Dosya silindi!');
    }
}
