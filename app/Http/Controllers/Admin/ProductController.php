<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'primaryImage']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']) . '-' . random_int(1000, 9999);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_new'] = $request->boolean('is_new');
        $data['is_flashsale'] = $request->boolean('is_flashsale');
        $data['flashsale_ends_at'] = $data['is_flashsale']
            ? ($data['flashsale_ends_at'] ?? null)
            : null;

        DB::transaction(function () use ($request, $data) {
            $product = Product::create(
                collect($data)->except(['images', 'primary_image_index'])->toArray()
            );

            $primaryIndex = (int) ($data['primary_image_index'] ?? 0);

            foreach ($request->file('images', []) as $index => $file) {
                $path = $file->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === $primaryIndex,
                    'sort_order' => $index,
                ]);
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        $product->load('images');
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? $product->slug;
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_new'] = $request->boolean('is_new');
        $data['is_flashsale'] = $request->boolean('is_flashsale');
        $data['flashsale_ends_at'] = $data['is_flashsale']
            ? ($data['flashsale_ends_at'] ?? null)
            : null;

        DB::transaction(function () use ($request, $data, $product) {
            $product->update(
                collect($data)->except(['images', 'primary_image_id', 'delete_image_ids'])->toArray()
            );

            if (! empty($data['delete_image_ids'])) {
                $images = ProductImage::whereIn('id', $data['delete_image_ids'])
                    ->where('product_id', $product->id)
                    ->get();

                foreach ($images as $image) {
                    \Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            $lastOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('images', []) as $index => $file) {
                $path = $file->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => false,
                    'sort_order' => $lastOrder + $index + 1,
                ]);
            }

            if (! empty($data['primary_image_id'])) {
                $product->images()->update(['is_primary' => false]);
                ProductImage::where('id', $data['primary_image_id'])->update(['is_primary' => true]);
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete(); // soft delete, gambar tetap tersimpan untuk keperluan restore

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
