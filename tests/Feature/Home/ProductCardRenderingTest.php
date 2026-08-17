<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\User;

it('shows rating and secondary image for homepage product cards', function () {
    $category = Category::factory()->create();
    $user = User::factory()->create();

    $product = Product::factory()->create([
        'name' => 'Roti Keju Delight',
        'slug' => 'roti-keju-delight',
        'is_active' => true,
        'is_featured' => true,
        'category_id' => $category->id,
    ]);

    ProductImage::create([
        'product_id' => $product->id,
        'image_path' => 'products/primary.jpg',
        'is_primary' => true,
        'sort_order' => 1,
    ]);

    ProductImage::create([
        'product_id' => $product->id,
        'image_path' => 'products/secondary.jpg',
        'is_primary' => false,
        'sort_order' => 2,
    ]);

    ProductReview::create([
        'product_id' => $product->id,
        'user_id' => $user->id,
        'rating' => 5,
        'comment' => 'Enak banget',
        'is_approved' => true,
    ]);

    expect($product->rating)->toBe(5.0)
        ->and($product->secondaryImage)->not->toBeNull();

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Roti Keju Delight');
    $response->assertSee(asset('storage/products/secondary.jpg'));
});

it('shows catalog rating and respects sort order on product listing', function () {
    $category = Category::factory()->create();
    $user = User::factory()->create();

    $expensive = Product::factory()->create([
        'name' => 'Produk Mahal',
        'slug' => 'produk-mahal',
        'category_id' => $category->id,
        'price' => 150000,
        'discount_price' => 150000,
        'is_active' => true,
    ]);

    $cheap = Product::factory()->create([
        'name' => 'Produk Murah',
        'slug' => 'produk-murah',
        'category_id' => $category->id,
        'price' => 50000,
        'discount_price' => 50000,
        'is_active' => true,
    ]);

    ProductReview::create([
        'product_id' => $expensive->id,
        'user_id' => $user->id,
        'rating' => 4,
        'comment' => 'Bagus',
        'is_approved' => true,
    ]);

    $response = $this->get(route('products.index', ['sort' => 'termahal']));

    $response->assertOk();
    $response->assertSee('4.0');
    $response->assertSeeInOrder(['Produk Mahal', 'Produk Murah']);
});
