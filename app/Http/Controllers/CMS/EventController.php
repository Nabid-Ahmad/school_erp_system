<?php
 
 namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
 
 use App\Models\Event;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Storage;
 
 class EventController extends Controller
 {
     public function index()
     {
         $events = Event::latest()->get();
         return view('events.index', compact('events'));
     }
 
     public function create()
     {
         return view('events.create');
     }
 
     public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'nullable|string',
             'date' => 'required|date',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
 
         $imagePath = null;
         if ($request->hasFile('image')) {
             $imagePath = $request->file('image')->storeOnCloudinary('events')->getSecurePath();
         }
 
         Event::create([
             'title' => $request->title,
             'description' => $request->description,
             'date' => $request->date,
             'image' => $imagePath,
         ]);
 
         return redirect()->route('events.index')->with('success', 'Event created successfully.');
     }
 
     public function destroy(Event $event)
     {
         if ($event->image) {
             // Storage::disk('public')->delete($event->image);
         }
         $event->delete();
         return redirect()->route('events.index')->with('success', 'Event deleted.');
     }
 }
