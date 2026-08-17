<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        $settings = SiteSetting::pluck('value', 'key');

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:1024'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'maps_embed' => ['nullable', 'string'],
            'hour_monday' => ['nullable', 'string', 'max:50'],
            'hour_tuesday' => ['nullable', 'string', 'max:50'],
            'hour_wednesday' => ['nullable', 'string', 'max:50'],
            'hour_thursday' => ['nullable', 'string', 'max:50'],
            'hour_friday' => ['nullable', 'string', 'max:50'],
            'hour_saturday' => ['nullable', 'string', 'max:50'],
            'hour_sunday' => ['nullable', 'string', 'max:50'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        } else {
            unset($data['logo']);
        }

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
