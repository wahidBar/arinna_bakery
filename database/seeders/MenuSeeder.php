<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['label' => 'Beranda', 'url' => '/', 'sort_order' => 1],
            ['label' => 'Produk', 'url' => '/products', 'sort_order' => 2],
            ['label' => 'Blog', 'url' => '/blog', 'sort_order' => 3],
            ['label' => 'Tentang Kami', 'url' => '/about', 'sort_order' => 4],
            ['label' => 'Kontak', 'url' => '/contact', 'sort_order' => 5],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu + ['is_active' => true, 'open_new_tab' => false]);
        }
    }
}
