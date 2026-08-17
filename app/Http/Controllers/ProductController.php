<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Halaman katalog produk (/products) dengan filter kategori, rentang harga,
     * status diskon, sorting, dan search. Semua filter memakai query string
     * agar bisa di-share via URL, contoh: ?category=roti-manis&sort=termurah
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Product::with(['primaryImage', 'category'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('is_active', true);

        // Filter kategori (bisa multi-select, dipisah koma: ?category=roti-manis,pastry)
        if ($request->filled('category')) {
            $slugs = explode(',', $request->input('category'));
            $query->whereHas('category', fn ($q) => $q->whereIn('slug', $slugs));
        }

        // Filter rentang harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->input('max_price'));
        }

        // Filter status diskon
        if ($request->boolean('discount_only')) {
            $query->whereNotNull('discount_price');
        }

        // Search live (AJAX) by nama produk
        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->input('q').'%');
        }

        // Sorting
        match ($request->input('sort')) {
            'termurah' => $query->orderByRaw('COALESCE(discount_price, price) asc'),
            'termahal' => $query->orderByRaw('COALESCE(discount_price, price) desc'),
            'terlaris' => $query->orderByDesc('sold_count'),
            default => $query->latest(), // terbaru
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        // Jika request AJAX (live search/filter), kembalikan partial view saja
        if ($request->ajax()) {
            return view('products.partials.grid', compact('products'));
        }

        $randomBlog = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->inRandomOrder()
            ->first();

        return view('products.index', compact('products', 'categories', 'randomBlog'));
    }

    /**
     * Halaman detail produk (/products/{slug})
     */
    public function show(string $slug): View
    {
        $product = Product::with(['images', 'category'])
            ->withCount('reviews')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $reviews = $product->reviews()->with('user')->latest()->paginate(5);

        $relatedProducts = Product::with('primaryImage')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Cek apakah user login pernah membeli produk ini dan belum kasih review,
        // dipakai di view untuk menampilkan/menyembunyikan form review.
        $canReview = false;
        if (auth()->check()) {
            $canReview = auth()->user()->orders()
                ->where('status', 'selesai')
                ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
                ->exists();
        }

        return view('products.show', compact('product', 'reviews', 'relatedProducts', 'canReview'));
    }

    /**
     * Endpoint AJAX untuk live search dari search bar (navbar & halaman katalog).
     */
    public function search(Request $request): JsonResponse
    {
        $products = Product::where('is_active', true)
            ->where('name', 'like', '%'.$request->input('q').'%')
            ->with('primaryImage')
            ->take(8)
            ->get(['id', 'name', 'slug', 'price', 'discount_price']);

        return response()->json($products);
    }
}
