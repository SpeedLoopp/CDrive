<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LinkController extends Controller
{
    public function index()
    {
        $links = auth()->user()->files()->with('links')->get()->pluck('links')->flatten();
        return view('dashboard.links.index', compact('links'));
    }

    public function create(File $file)
    {
        if ($file->user_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.links.create', compact('file'));
    }

    public function store(Request $request, File $file)
    {
        if ($file->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'custom_link' => 'required|string|max:255|unique:links,custom_link|alpha_dash',
            'expiration_date' => 'nullable|date|after:now',
        ]);

        // XSS koruması: Sadece güvenli karakterlere izin ver
        $customLink = preg_replace('/[^a-zA-Z0-9\-_]/', '', $request->custom_link);
        $customLink = Str::slug($customLink);

        $link = Link::create([
            'file_id' => $file->id,
            'custom_link' => $customLink,
            'expiration_date' => $request->expiration_date,
        ]);

        return redirect()->route('links.index')->with('success', 'Link oluşturuldu!');
    }

    public function show($customLink)
    {
        // XSS ve Path Traversal koruması
        $customLink = preg_replace('/[^a-zA-Z0-9\-_]/', '', $customLink);
        
        $link = Link::where('custom_link', $customLink)->firstOrFail();

        if (!$link->isAccessible()) {
            abort(404, 'Link geçersiz veya süresi dolmuş.');
        }

        $link->increment('access_count');
        
        return view('public.download', compact('link'));
    }

    public function download($customLink)
    {
        // XSS ve Path Traversal koruması
        $customLink = preg_replace('/[^a-zA-Z0-9\-_]/', '', $customLink);
        
        $link = Link::where('custom_link', $customLink)->firstOrFail();

        if (!$link->isAccessible()) {
            abort(404, 'Link geçersiz veya süresi dolmuş.');
        }

        $file = $link->file;
        
        // Path Traversal koruması: Dosya yolunu kontrol et
        $filePath = $file->file_path;
        if (strpos($filePath, '..') !== false || strpos($filePath, './') !== false) {
            abort(403, 'Geçersiz dosya yolu.');
        }
        
        $file->increment('download_count');

        return Storage::disk('public')->download($filePath, $file->original_name);
    }

    public function destroy(Link $link)
    {
        if ($link->file->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $link->delete();
        return redirect()->back()->with('success', 'Link silindi!');
    }
}
