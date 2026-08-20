<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('type', 'blog')
            ->with('parent')
            ->withCount('blogs')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.blog-categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parentCategories = Category::where('type', 'blog')->whereNull('parent_id')->orderBy('name')->get();

        return view('admin.blog-categories.create', compact('parentCategories'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['type'] = 'blog';

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.settings.blog-categories.index')->with('success', 'Kategori blog berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        $parentCategories = Category::where('type', 'blog')
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.blog-categories.edit', compact('category', 'parentCategories'));
    }

    public function update(StoreCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? $category->slug;
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('icon')) {
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            $data['icon'] = $request->file('icon')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.settings.blog-categories.index')->with('success', 'Kategori blog berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->blogs()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki artikel blog.');
        }

        $category->delete();

        return redirect()->route('admin.settings.blog-categories.index')->with('success', 'Kategori blog berhasil dihapus.');
    }
}
