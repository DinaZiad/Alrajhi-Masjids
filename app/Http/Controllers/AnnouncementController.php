<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $masjids = \App\Models\Masjid::all();
        return view('announcements.create', compact('masjids'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'display_start_at' => 'nullable|date',
            'display_end_at' => 'nullable|date',
            'masjid_id' => 'required|exists:masjids,id',
        ]);
        $validated['is_urgent'] = $request->has('is_urgent');

        Announcement::create($validated);

        return redirect()->route('announcements.index')->with('success', 'تم إضافة الإعلان بنجاح');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for creating a new urgent announcement.
     */
    public function createUrgent()
    {
        $masjids = \App\Models\Masjid::all();
        return view('announcements.create-urgent', compact('masjids'));
    }

    /**
     * Store a newly created urgent announcement in storage.
     */
    public function storeUrgent(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'display_start_at' => 'nullable|date',
            'display_end_at' => 'nullable|date|after:display_start_at',
            'masjid_id' => 'required|exists:masjids,id',
        ]);
        
        // Force is_urgent to true for urgent announcements
        $validated['is_urgent'] = true;

        Announcement::create($validated);

        return redirect()->route('announcements.index')
            ->with('success', 'تم إضافة الإعلان العاجل بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        $masjids = \App\Models\Masjid::all();
        return view('announcements.edit', compact('announcement', 'masjids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'display_start_at' => 'nullable|date',
            'display_end_at' => 'nullable|date',
            'masjid_id' => 'required|exists:masjids,id',
        ]);
        $validated['is_urgent'] = $request->has('is_urgent');
        $announcement->update($validated);
        return redirect()->route('announcements.index')->with('success', 'تم تحديث الإعلان بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'تم حذف الإعلان بنجاح');
    }
}
