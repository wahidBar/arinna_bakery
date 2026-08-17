<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $settings = [
            'email' => SiteSetting::get('email'),
            'phone' => SiteSetting::get('phone'),
            'whatsapp' => SiteSetting::get('whatsapp'),
            'address' => SiteSetting::get('address'),
            'maps_embed' => SiteSetting::get('maps_embed'),
            'hours' => [
                'Senin' => SiteSetting::get('hour_monday'),
                'Selasa' => SiteSetting::get('hour_tuesday'),
                'Rabu' => SiteSetting::get('hour_wednesday'),
                'Kamis' => SiteSetting::get('hour_thursday'),
                'Jumat' => SiteSetting::get('hour_friday'),
                'Sabtu' => SiteSetting::get('hour_saturday'),
                'Minggu' => SiteSetting::get('hour_sunday'),
            ],
        ];

        return view('contact.index', compact('settings'));
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $contact = Contact::create($request->validated());

        // Kirim email notifikasi ke admin. Mailable dibuat di modul notifikasi (bagian 5.5).
        // Mail::to(SiteSetting::get('email'))->send(new NewContactMessage($contact));

        return back()->with('success', 'Pesan Anda berhasil terkirim. Kami akan segera menghubungi Anda.');
    }
}
