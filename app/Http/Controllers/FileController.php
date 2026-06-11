<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\FileCategory;
use App\Models\StoredFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function indexByCategory(string $slug)
    {
        $category = FileCategory::where('slug', $slug)->firstOrFail();
        $files = $category->files()->latest()->paginate(20);

        return view('files.index', compact('category', 'files'));
    }

    /**
     * Show main file management page listing categories.
     */
    public function index()
    {
        $categories = FileCategory::orderBy('name')->get();

        return view('files.home', compact('categories'));
    }

    public function upload(Request $request, string $slug)
    {
        $category = FileCategory::where('slug', $slug)->firstOrFail();

        $request->validate([
            'file' => ['required', 'file'],
        ]);

        $file = $request->file('file');
        $userId = $request->user()->id;
        $dir = $category->slug . '/' . $userId;
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $file->getClientOriginalName());
        $path = $file->storeAs($dir, $filename, 'public');

        $stored = StoredFile::create([
            'file_category_id' => $category->id,
            'user_id' => $userId,
            'original_name' => $file->getClientOriginalName(),
            'filename' => $filename,
            'path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()->back()->with('success', 'File uploaded.');
    }

    public function download(StoredFile $file)
    {
        if (!Storage::disk('public')->exists($file->path)) {
            abort(404);
        }

        return Storage::disk('public')->download($file->path, $file->original_name);
    }

    public function destroy(StoredFile $file)
    {
        $user = request()->user();
        if ($file->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        return redirect()->back()->with('success', 'File removed.');
    }
}
