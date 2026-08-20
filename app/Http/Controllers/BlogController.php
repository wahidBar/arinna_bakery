<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Blog::with(['category', 'author', 'comments' => function ($q) {
            $q->whereNull('parent_id')->with('replies')->latest();
        }])->where('is_published', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->input('category')));
        }

        $paginator = $query->latest('published_at')->paginate(1)->withQueryString();
        $blog = $paginator->first();

        $recentBlogs = Blog::where('is_published', true)
            ->latest('published_at')
            ->take(4)
            ->get();

        $categories = Category::where('type', 'blog')->withCount('blogs')->get();

        return view('blog.show', compact('blog', 'paginator', 'recentBlogs', 'categories'));
    }

    public function show(string $slug): View
    {
        // For direct links, we don't paginate, just show the specific blog.
        $blog = Blog::with(['category', 'author', 'comments' => function ($q) {
            $q->whereNull('parent_id')->with('replies')->latest();
        }])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $recentBlogs = Blog::where('is_published', true)
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        $categories = Category::where('type', 'blog')->withCount('blogs')->get();

        return view('blog.show', compact('blog', 'recentBlogs', 'categories'));
    }

    public function storeComment(Request $request, Blog $blog)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ]);

        $blog->comments()->create($request->only('name', 'email', 'message', 'parent_id'));

        return back()->with('success', 'Comment has been added successfully.');
    }
}
