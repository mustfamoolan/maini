<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display checkout page.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'السلة فارغة');
        }

        $currency = Setting::getValue('currency', 'ر.س');
        return view('menu.checkout', compact('cart', 'currency'));
    }

    /**
     * Send order to WhatsApp.
     */
    public function sendWhatsApp(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'السلة فارغة')->withInput();
        }

        $whatsappNumber = Setting::getValue('whatsapp_number', '');
        
        if (empty($whatsappNumber)) {
            return back()->with('error', 'رقم الواتساب غير محدد. يرجى التواصل مع الإدارة.')->withInput();
        }

        $message = $this->buildWhatsAppMessage($cart, $request->all());
        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";

        // Clear cart after sending order
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'whatsapp_url' => $whatsappUrl,
        ]);
    }

    /**
     * Build WhatsApp message.
     */
    private function buildWhatsAppMessage($cart, $customerData)
    {
        $currency = Setting::getValue('currency', 'ر.س');
        
        $message = "🍽️ *طلب جديد*\n\n";
        
        $message .= "📋 *الطلبات:*\n";
        $total = 0;
        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $total += $itemTotal;
            $message .= "• {$item['name']} × {$item['quantity']} = " . number_format($itemTotal, 2) . " {$currency}\n";
        }
        
        $message .= "\n💰 *الإجمالي: " . number_format($total, 2) . " {$currency}*\n\n";
        
        $message .= "👤 *معلومات العميل:*\n";
        $message .= "• الاسم: {$customerData['name']}\n";
        $message .= "• الهاتف: {$customerData['phone']}\n";
        $message .= "• العنوان: {$customerData['address']}\n";
        
        if (!empty($customerData['notes'])) {
            $message .= "\n📝 *ملاحظات:*\n{$customerData['notes']}";
        }

        return $message;
    }
}
