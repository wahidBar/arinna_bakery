<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $flashsaleProducts = Product::with(['images', 'primaryImage', 'secondaryImage', 'category'])
            ->where('is_flashsale', true)
            ->where('is_flashsale', true)
            // ->andwhere('flashsale_ends_at', '>', now())
            ->latest()
            ->take(12)
            ->get();

        // ambil waktu berakhir deal (pakai deal terdekat / global)
        $dealEndsAt = $flashsaleProducts->min('flashsale_ends_at') ?? now()->addDay();

        $featuredProducts = Product::with(['images', 'primaryImage', 'secondaryImage', 'category'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $newestProducts = Product::with(['images', 'primaryImage', 'secondaryImage', 'category'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        // Kategori untuk tab "New Arrivals" — ambil kategori aktif
        // yang punya produk aktif, urut sesuai sort_order.
        // Batasi 3 kategori (di luar tab "All") biar layout tab tidak terlalu panjang.
        $productTabCategories = Category::where('is_active', true)
            ->whereHas('products', fn($q) => $q->where('is_active', true))
            ->orderBy('sort_order')
            ->take(3)
            ->get()
            ->map(function (Category $category) {
                $category->tab_products = Product::with(['images', 'primaryImage', 'secondaryImage', 'category'])
                    ->where('category_id', $category->id)
                    ->where('is_active', true)
                    ->latest()
                    ->take(8)
                    ->get();

                return $category;
            });

        $latestBlogs = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('home', compact(
            'sliders',
            'flashsaleProducts',
            'dealEndsAt',
            'featuredProducts',
            'newestProducts',
            'productTabCategories',
            'latestBlogs'
        ));
    }
}
