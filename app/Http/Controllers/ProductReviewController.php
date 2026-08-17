<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductReviewRequest;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class ProductReviewController extends Controller
{
    public function store(StoreProductReviewRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        // Pastikan order_item benar-benar milik user ini dan produk ini,
        // supaya orang tidak bisa review pakai order_item_id milik user lain.
        $orderItem = OrderItem::where('id', $data['order_item_id'])
            ->where('product_id', $product->id)
            ->whereHas('order', function ($q) {
                $q->where('user_id', auth()->id())->where('status', 'selesai');
            })
            ->firstOrFail();

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reviews', 'public');
        }

        $product->reviews()->create([
            'user_id' => auth()->id(),
            'order_item_id' => $orderItem->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'photo' => $photoPath,
            'is_approved' => false, // menunggu approval admin (lihat modul CMS)
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda akan tampil setelah disetujui admin.');
    }
}
