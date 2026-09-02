<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::with('category', 'author')->withCount('comments')->latest()->paginate(15);
        $categories = Category::where('type', 'blog')->orderBy('name')->get();

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'blog')->orderBy('name')->get();

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['author_id'] = auth()->id();
        $data['is_published'] = $request->boolean('is_published');
        $data['thumbnail'] = $request->file('thumbnail')->store('blogs', 'public');

        Blog::create($data);

        return redirect()->route('admin.settings.blogs.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Blog $blog): View
    {
        $categories = Category::where('type', 'blog')->orderBy('name')->get();

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(StoreBlogRequest $request, Blog $blog): RedirectResponse
    {
        $data = $request->validated();
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

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'blog_ids' => ['required', 'array', 'min:1'],
            'blog_ids.*' => ['integer', 'distinct', 'exists:blogs,id'],
        ]);

        foreach (Blog::whereIn('id', $validated['blog_ids'])->get() as $blog) {
            \Storage::disk('public')->delete($blog->thumbnail);
            $blog->delete();
        }

        return redirect()->route('admin.settings.blogs.index')->with('success', count($validated['blog_ids']).' artikel berhasil dihapus.');
    }
}
