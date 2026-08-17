<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::with('category', 'author')->latest()->paginate(15);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['author_id'] = auth()->id();
        $data['is_published'] = $request->boolean('is_published');
        $data['thumbnail'] = $request->file('thumbnail')->store('blogs', 'public');

        Blog::create($data);

        return redirect()->route('admin.settings.blogs.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Blog $blog): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(StoreBlogRequest $request, Blog $blog): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? $blog->slug;
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('thumbnail')) {
            \Storage::disk('public')->delete($blog->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.settings.blogs.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        \Storage::disk('public')->delete($blog->thumbnail);
        $blog->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}
