<?php
 
 namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
 
 use App\Models\Gallery;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Storage;
 
 class GalleryController extends Controller
 {
     public function index()
     {
         $galleries = Gallery::latest()->get();
         return view('gallery.index', compact('galleries'));
     }
 
     public function create()
     {
         return view('gallery.create');
     }
 
     public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string|max:255',
             'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
 
         $imagePath = $request->file('image')->storeOnCloudinary('gallery')->getSecurePath();
 
         Gallery::create([
             'title' => $request->title,
             'image' => $imagePath,
         ]);
 
         return redirect()->route('galleries.index')->with('success', 'Gallery image added successfully.');
     }
 
     public function destroy(Gallery $gallery)
     {
         // Storage::disk('public')->delete($gallery->image);
         $gallery->delete();
         return redirect()->route('galleries.index')->with('success', 'Gallery image deleted.');
     }
 }
