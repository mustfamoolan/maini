<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $currency = \App\Models\Setting::getValue('currency', 'ر.س');
        return view('menu.cart', compact('cart', 'currency'));
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'dish_id' => 'required|exists:dishes,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $dish = Dish::findOrFail($validated['dish_id']);
        $cart = session()->get('cart', []);
        $quantity = $validated['quantity'] ?? 1;

        if (isset($cart[$dish->id])) {
            $cart[$dish->id]['quantity'] += $quantity;
        } else {
            $cart[$dish->id] = [
                'id' => $dish->id,
                'name' => $dish->name,
                'price' => $dish->price,
                'image' => $dish->image,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'تمت الإضافة إلى السلة',
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'dish_id' => 'required|exists:dishes,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$validated['dish_id']])) {
            $cart[$validated['dish_id']]['quantity'] = $validated['quantity'];
            session()->put('cart', $cart);
        }

        $total = $this->calculateTotal($cart);

        return response()->json([
            'success' => true,
            'total' => number_format($total, 2),
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function remove(Request $request)
    {
        $validated = $request->validate([
            'dish_id' => 'required|exists:dishes,id',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$validated['dish_id']])) {
            unset($cart[$validated['dish_id']]);
            session()->put('cart', $cart);
        }

        $total = $this->calculateTotal($cart);

        return response()->json([
            'success' => true,
            'total' => number_format($total, 2),
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /**
     * Get cart data.
     */
    public function getCart()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        return response()->json([
            'cart' => $cart,
            'total' => number_format($total, 2),
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /**
     * Calculate total price.
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
