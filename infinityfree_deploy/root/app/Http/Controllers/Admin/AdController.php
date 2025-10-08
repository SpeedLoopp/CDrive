<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::latest()->paginate(20);
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:header,footer,popup,sidebar',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'display_order' => 'nullable|integer',
        ]);

        // XSS koruması: Sadece admin ekleyebilir ve tehlikeli scriptler temizlenir
        $content = $this->sanitizeAdContent($request->content);

        Ad::create([
            'type' => $request->type,
            'title' => $request->title,
            'content' => $content,
            'display_order' => $request->display_order ?? 0,
            'active' => true,
        ]);

        return redirect()->route('admin.ads.index')->with('success', 'Reklam oluşturuldu!');
    }

    public function edit(Ad $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $request->validate([
            'type' => 'required|in:header,footer,popup,sidebar',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'display_order' => 'nullable|integer',
        ]);

        // XSS koruması
        $content = $this->sanitizeAdContent($request->content);

        $ad->update([
            'type' => $request->type,
            'title' => $request->title,
            'content' => $content,
            'display_order' => $request->display_order ?? 0,
        ]);

        return redirect()->route('admin.ads.index')->with('success', 'Reklam güncellendi!');
    }

    public function toggleStatus(Ad $ad)
    {
        $ad->update(['active' => !$ad->active]);
        return redirect()->back()->with('success', 'Reklam durumu güncellendi!');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->back()->with('success', 'Reklam silindi!');
    }

    /**
     * XSS koruması için reklam içeriğini temizle
     * Sadece güvenli HTML etiketlerine izin ver
     */
    private function sanitizeAdContent($content)
    {
        // İzin verilen HTML etiketleri
        $allowedTags = '<div><span><p><h1><h2><h3><h4><h5><h6><a><img><br><strong><em><b><i><u><ul><ol><li><table><tr><td><th>';
        
        // Tehlikeli etiketleri temizle
        $content = strip_tags($content, $allowedTags);
        
        // Script etiketlerini ve javascript: protokolünü kaldır
        $content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $content);
        $content = preg_replace('/on\w+\s*=\s*["\'].*?["\']/i', '', $content); // onclick, onload vb.
        $content = preg_replace('/javascript:/i', '', $content);
        
        return $content;
    }
}
