<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Arinna Hidayah Bakery',
            'logo' => 'settings/logo.png',
            'email' => 'info@arinnahidayahbakery.com',
            'phone' => '0812-3456-7890',
            'whatsapp' => '628123456789',
            'address' => 'Jl. Raya Bakery No. 10, Mojokerto, Jawa Timur',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen loading="lazy"></iframe>',
            'hour_monday' => '07:00 - 21:00',
            'hour_tuesday' => '07:00 - 21:00',
            'hour_wednesday' => '07:00 - 21:00',
            'hour_thursday' => '07:00 - 21:00',
            'hour_friday' => '07:00 - 21:00',
            'hour_saturday' => '07:00 - 22:00',
            'hour_sunday' => '08:00 - 20:00',
            'instagram' => 'https://instagram.com/arinnahidayahbakery',
            'facebook' => 'https://facebook.com/arinnahidayahbakery',
            'tiktok' => 'https://tiktok.com/@arinnahidayahbakery',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::create(['key' => $key, 'value' => $value]);
        }
    }
}
