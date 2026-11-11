<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest()->get();
        return view('notices.index', compact('notices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'audience' => 'required|string',
            'priority' => 'required|string',
            'content' => 'required|string',
        ]);

        $validated['notice_id'] = 'NOT-' . str_pad(Notice::count() + 1, 2, '0', STR_PAD_LEFT);
        $validated['date'] = now();

        $notice = Notice::create($validated);

        ActivityLog::create([
            'type' => 'notice',
            'message' => "New circular broadcasted: \"{$notice->title}\""
        ]);

        return redirect()->route('notices.index')->with('success', "Notice published successfully!");
    }
}
