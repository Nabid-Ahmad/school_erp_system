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
 
         $imagePath = cloudinary()->uploadApi()->upload($request->file('image')->getRealPath(), ['folder' => 'gallery'])['secure_url'];
 
         Gallery::create([
             'title' => $request->title,
             'image' => $imagePath,
         ]);
 
         return redirect()->route('galleries.index')->with('success', 'Gallery image added successfully.');
     }
 
     public function destroy(Gallery $gallery)
     {
         if ($gallery->image && str_contains($gallery->image, 'res.cloudinary.com')) {
             try {
                 $parts = explode('/upload/', $gallery->image);
                 if (isset($parts[1])) {
                     $pathParts = explode('/', $parts[1]);
                     array_shift($pathParts);
                     $publicIdWithExt = implode('/', $pathParts);
                     $publicId = pathinfo($publicIdWithExt, PATHINFO_DIRNAME) . '/' . pathinfo($publicIdWithExt, PATHINFO_FILENAME);
                     cloudinary()->uploadApi()->destroy($publicId);
                 }
             } catch (\Exception $e) {}
         }
 
         $gallery->delete();
         return redirect()->route('galleries.index')->with('success', 'Image deleted successfully.');
     }
 }
