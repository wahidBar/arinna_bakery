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
        $query = Blog::with('category', 'author')
            ->where('is_published', true)
            ->whereNotNull('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->input('category')));
        }

        $blogs = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = Category::whereHas('blogs')->get();

        return view('blog.index', compact('blogs', 'categories'));
    }

    public function show(string $slug): View
    {
        $blog = Blog::with('category', 'author')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedBlogs = Blog::where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->where('is_published', true)
            ->take(3)
            ->get();

        return view('blog.show', compact('blog', 'relatedBlogs'));
    }
}
