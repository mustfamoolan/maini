<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        $whatsappNumber = Setting::getValue('whatsapp_number', '');
        $currency = Setting::getValue('currency', 'ر.س');
        $menuUrl = url('/');
        $qrCodeSvg = QrCode::format('svg')->size(300)->generate($menuUrl);
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        return view('admin.settings', compact('whatsappNumber', 'currency', 'qrCode', 'menuUrl'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number' => 'required|string|max:20',
            'currency' => 'required|string|max:10',
        ]);

        // Remove any non-numeric characters except +
        $validated['whatsapp_number'] = preg_replace('/[^0-9+]/', '', $validated['whatsapp_number']);

        Setting::setValue('whatsapp_number', $validated['whatsapp_number']);
        Setting::setValue('currency', $validated['currency']);

        return redirect()->route('admin.settings.index')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }

    /**
     * Download QR code.
     */
    public function downloadQrCode()
    {
        $menuUrl = url('/');
        $qrCode = QrCode::format('svg')->size(500)->generate($menuUrl);

        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="menu-qr-code.svg"');
    }
}
