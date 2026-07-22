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
             $imagePath = cloudinary()->uploadApi()->upload($request->file('image')->getRealPath(), ['folder' => 'events'])['secure_url'];
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
         if ($event->image && str_contains($event->image, 'res.cloudinary.com')) {
             try {
                 $parts = explode('/upload/', $event->image);
                 if (isset($parts[1])) {
                     $pathParts = explode('/', $parts[1]);
                     array_shift($pathParts);
                     $publicIdWithExt = implode('/', $pathParts);
                     $publicId = pathinfo($publicIdWithExt, PATHINFO_DIRNAME) . '/' . pathinfo($publicIdWithExt, PATHINFO_FILENAME);
                     cloudinary()->uploadApi()->destroy($publicId);
                 }
             } catch (\Exception $e) {}
         }
 
         $event->delete();
         return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
     }
 }
