<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::with('file.user')->latest()->paginate(20);
        return view('admin.links.index', compact('links'));
    }

    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->back()->with('success', 'Link silindi!');
    }
}
