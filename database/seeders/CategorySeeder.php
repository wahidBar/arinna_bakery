<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * 12 kategori utama sesuai brief Arinna Hidayah Bakery.
     */
    public function run(): void
    {
        $categories = [
            'Coffee Series',
            'Milk Series',
            'Ice Cream',
            'Roti Manis',
            'Roti Gurih',
            'Pastry',
            'Cake Tart',
            'Donat',
            'Dessert',
            'Kue Basah',
            'Kue Soes',
            'Cake Oleh-oleh',
        ];

        foreach ($categories as $index => $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'icon' => null,
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }
    }
}
