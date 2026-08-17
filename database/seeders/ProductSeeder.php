<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Nama produk realistis per kategori (minimal 10 per kategori sesuai brief).
     * Sisanya (jika kurang dari 10) dilengkapi via factory agar tetap random tapi valid.
     */
    protected array $productNames = [
        'Coffee Series' => [
            'Kopi Susu Gula Aren', 'Cappuccino Klasik', 'Caramel Macchiato', 'Es Kopi Kayu Manis',
            'Kopi Tubruk Original', 'Latte Vanilla', 'Americano Dingin', 'Kopi Susu Hazelnut',
            'Affogato Bakery', 'Es Kopi Pandan',
        ],
        'Milk Series' => [
            'Susu Coklat Premium', 'Taro Milk', 'Matcha Milk', 'Red Velvet Milk',
            'Milk Original', 'Susu Stroberi', 'Thai Tea Milk', 'Susu Vanilla Klasik',
            'Milk Choco Hazelnut', 'Susu Karamel',
        ],
        'Ice Cream' => [
            'Ice Cream Vanilla', 'Ice Cream Coklat', 'Ice Cream Stroberi', 'Ice Cream Matcha',
            'Ice Cream Taro', 'Ice Cream Kopi', 'Ice Cream Mangga', 'Ice Cream Kelapa Muda',
            'Ice Cream Cookies n Cream', 'Ice Cream Durian',
        ],
        'Roti Manis' => [
            'Roti Coklat Keju', 'Roti Pisang Coklat', 'Roti Sobek Isi Vanila', 'Roti Boy Mentega',
            'Roti Kelapa', 'Roti Kacang Hijau', 'Roti Blueberry', 'Roti Selai Strawberry',
            'Roti Sobek Coklat', 'Roti Susu Manis',
        ],
        'Roti Gurih' => [
            'Roti Sosis Mayo', 'Roti Abon Sapi', 'Roti Keju Sapi', 'Roti Beef Smoke',
            'Roti Tuna Mayo', 'Roti Ayam Suwir', 'Roti Ragout Ayam', 'Roti Sosis Keju',
            'Roti Pizza Mini', 'Roti Bakar Sapi',
        ],
        'Pastry' => [
            'Croissant Butter', 'Croissant Coklat', 'Danish Keju', 'Puff Pastry Sosis',
            'Croissant Almond', 'Danish Blueberry', 'Puff Pastry Kentang', 'Croissant Matcha',
            'Danish Apel', 'Puff Pastry Coklat',
        ],
        'Cake Tart' => [
            'Fruit Tart Mini', 'Cheese Tart', 'Chocolate Tart', 'Egg Tart Klasik',
            'Tart Buah Segar', 'Tart Coklat Almond', 'Tart Lemon', 'Tart Karamel',
            'Tart Matcha', 'Tart Strawberry',
        ],
        'Donat' => [
            'Donat Coklat Meses', 'Donat Gula Halus', 'Donat Kentang Original', 'Donat Keju',
            'Donat Matcha Almond', 'Donat Karamel', 'Donat Oreo', 'Donat Strawberry',
            'Donat Taro', 'Donat Glaze Original',
        ],
        'Dessert' => [
            'Puding Coklat', 'Puding Karamel', 'Tiramisu Cup', 'Mango Sticky Rice',
            'Puding Roti', 'Panna Cotta Mangga', 'Dessert Box Oreo', 'Dessert Box Red Velvet',
            'Puding Kelapa Muda', 'Puding Fruit Cocktail',
        ],
        'Kue Basah' => [
            'Kue Lapis Legit', 'Kue Talam', 'Kue Nagasari', 'Kue Cucur',
            'Kue Putri Salju', 'Kue Klepon', 'Kue Lumpur', 'Kue Bugis',
            'Kue Dadar Gulung', 'Kue Pukis',
        ],
        'Kue Soes' => [
            'Soes Vla Vanila', 'Soes Coklat', 'Soes Durian', 'Soes Keju',
            'Soes Karamel', 'Soes Matcha', 'Soes Strawberry', 'Soes Tiramisu',
            'Soes Kacang', 'Soes Original',
        ],
        'Cake Oleh-oleh' => [
            'Bolu Gulung Original', 'Brownies Panggang', 'Bolu Marmer', 'Kue Bolu Pandan',
            'Brownies Kukus', 'Bolu Gulung Keju', 'Kastengel Toples', 'Nastar Toples',
            'Putri Salju Toples', 'Cake Oleh-oleh Coklat',
        ],
    ];

    public function run(): void
    {
        foreach ($this->productNames as $categoryName => $names) {
            $category = Category::where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            foreach ($names as $name) {
                $price = fake()->numberBetween(8, 120) * 1000;
                $hasDiscount = fake()->boolean(30);

                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
                    'sku' => 'SKU-' . strtoupper(Str::random(8)),
                    'price' => $price,
                    'discount_price' => $hasDiscount ? (int) ($price * fake()->randomFloat(2, 0.7, 0.9)) : null,
                    'stock' => fake()->numberBetween(0, 100),
                    'weight' => fake()->randomElement(['100 gram', '150 gram', '250 gram', '500 gram', '1 pcs', '1 box (6 pcs)']),
                    'description' => "Nikmati {$name} dari Arinna Hidayah Bakery, dibuat fresh setiap hari dengan bahan pilihan berkualitas.",
                    'information' => 'Komposisi: tepung terigu, gula, telur, mentega, dan bahan pilihan lainnya. Simpan di suhu ruang, konsumsi maksimal 2 hari untuk kualitas terbaik.',
                    'is_active' => true,
                    'is_featured' => fake()->boolean(20),
                    'is_new' => fake()->boolean(25),
                    'sold_count' => fake()->numberBetween(0, 500),
                ]);

                // Placeholder gambar produk (ganti dengan upload asli di admin nanti)
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'products/placeholder.jpg',
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }
        }
    }
}
