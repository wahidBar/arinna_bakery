<?php

use App\Models\Blog;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);
});

test('admin dashboard page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Materio Admin');
    $response->assertSee('Analisis Omzet Penjualan');
});

test('admin products index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.products.index'));
    $response->assertStatus(200);
    $response->assertSee('Katalog');
    $response->assertSee('Tambah Produk');
});

test('admin categories index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.categories.index'));
    $response->assertStatus(200);
    $response->assertSee('Kategori Produk');
});

test('admin orders index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.orders.index'));
    $response->assertStatus(200);
    $response->assertSee('Manajemen Pesanan');
});

test('admin reviews index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.reviews.index'));
    $response->assertStatus(200);
    $response->assertSee('Ulasan');
});

test('admin users index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
    $response->assertStatus(200);
    $response->assertSee('Manajemen Pengguna');
});

test('admin settings general edit page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.settings.general.edit'));
    $response->assertStatus(200);
    $response->assertSee('Informasi Umum');
});

test('admin menus index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.settings.menus.index'));
    $response->assertStatus(200);
    $response->assertSee('Menu Navigasi');
});

test('admin sliders index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.settings.sliders.index'));
    $response->assertStatus(200);
    $response->assertSee('Slider Hero');
});

test('admin blog categories index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.settings.blog-categories.index'));
    $response->assertStatus(200);
    $response->assertSee('Kategori Blog');
});

test('admin blogs index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.settings.blogs.index'));
    $response->assertStatus(200);
    $response->assertSee('Artikel Blog');
});

test('admin team members index page can be rendered', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.settings.team-members.index'));
    $response->assertStatus(200);
    $response->assertSee('Profil Tim');
});

test('admin products create and edit pages can be rendered', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    $this->actingAs($this->admin)->get(route('admin.products.create'))->assertStatus(200);
    $this->actingAs($this->admin)->get(route('admin.products.edit', $product))->assertStatus(200);
});

test('admin categories create and edit pages can be rendered', function () {
    $category = Category::factory()->create();

    $this->actingAs($this->admin)->get(route('admin.categories.create'))->assertStatus(200);
    $this->actingAs($this->admin)->get(route('admin.categories.edit', $category))->assertStatus(200);
});

test('admin users create, edit, and show pages can be rendered', function () {
    $user = User::factory()->create();

    $this->actingAs($this->admin)->get(route('admin.users.create'))->assertStatus(200);
    $this->actingAs($this->admin)->get(route('admin.users.edit', $user))->assertStatus(200);
    $this->actingAs($this->admin)->get(route('admin.users.show', $user))->assertStatus(200);
});

test('admin sliders create and edit pages can be rendered', function () {
    $slider = Slider::create([
        'image' => 'sliders/sample.jpg',
        'title' => 'Test Slider',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->actingAs($this->admin)->get(route('admin.settings.sliders.create'))->assertStatus(200);
    $this->actingAs($this->admin)->get(route('admin.settings.sliders.edit', $slider))->assertStatus(200);
});

test('admin blog categories create and edit pages can be rendered', function () {
    $blogCat = Category::create([
        'name' => 'Resep Roti',
        'slug' => 'resep-roti',
        'type' => 'blog',
        'is_active' => true,
    ]);

    $this->actingAs($this->admin)->get(route('admin.settings.blog-categories.create'))->assertStatus(200);
    $this->actingAs($this->admin)->get(route('admin.settings.blog-categories.edit', $blogCat))->assertStatus(200);
});

test('admin blogs create and edit pages can be rendered', function () {
    $blog = Blog::create([
        'title' => 'Tips Roti Lembut',
        'slug' => 'tips-roti-lembut',
        'content' => 'Konten tips roti...',
        'author_id' => $this->admin->id,
        'is_published' => true,
    ]);

    $this->actingAs($this->admin)->get(route('admin.settings.blogs.create'))->assertStatus(200);
    $this->actingAs($this->admin)->get(route('admin.settings.blogs.edit', $blog))->assertStatus(200);
});

test('admin team members create and edit pages can be rendered', function () {
    $member = TeamMember::create([
        'name' => 'Chef Budi',
        'role' => 'Baker',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->actingAs($this->admin)->get(route('admin.settings.team-members.create'))->assertStatus(200);
    $this->actingAs($this->admin)->get(route('admin.settings.team-members.edit', $member))->assertStatus(200);
});

test('admin orders show page can be rendered', function () {
    $order = Order::create([
        'user_id' => $this->admin->id,
        'invoice_no' => 'INV-TEST-001',
        'total_price' => 50000,
        'status' => 'pending',
        'payment_status' => 'pending',
        'payment_method' => 'qris',
        'shipping_name' => 'Admin Test',
        'shipping_phone' => '08123456789',
        'shipping_address' => 'Jl. Bakery No. 1',
    ]);

    $this->actingAs($this->admin)->get(route('admin.orders.show', $order))->assertStatus(200);
});

test('admin dynamic product album crud endpoints work', function () {
    Storage::fake('public');

    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    $file = UploadedFile::fake()->image('bakery_sample.jpg');

    // 1. Upload image to album
    $res = $this->actingAs($this->admin)->postJson(route('admin.products.images.store', $product), [
        'image' => $file,
    ]);
    $res->assertStatus(200)->assertJson(['success' => true]);

    $image1 = ProductImage::where('product_id', $product->id)->first();
    expect($image1)->not->toBeNull();

    // 2. Add second image and test setPrimary
    $image2 = ProductImage::create([
        'product_id' => $product->id,
        'image_path' => 'products/sample2.jpg',
        'is_primary' => false,
        'sort_order' => 2,
    ]);

    $res2 = $this->actingAs($this->admin)->patchJson(route('admin.products.images.primary', $image2));
    $res2->assertStatus(200)->assertJson(['success' => true]);
    expect($image2->fresh()->is_primary)->toBeTrue();
    expect($image1->fresh()->is_primary)->toBeFalse();

    // 3. Reorder
    $res3 = $this->actingAs($this->admin)->postJson(route('admin.products.images.reorder', $product), [
        'order' => [$image2->id, $image1->id],
    ]);
    $res3->assertStatus(200)->assertJson(['success' => true]);

    // 4. Delete image
    $res4 = $this->actingAs($this->admin)->deleteJson(route('admin.products.images.destroy', $image1));
    $res4->assertStatus(200)->assertJson(['success' => true]);
    expect(ProductImage::find($image1->id))->toBeNull();
});
