<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishes = Dish::with('category')->get();
        $currency = \App\Models\Setting::getValue('currency', 'ر.س');
        return view('admin.dishes.index', compact('dishes', 'currency'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.dishes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('dishes', 'public');
        }

        Dish::create($validated);

        return redirect()->route('admin.dishes.index')
            ->with('success', 'تم إضافة الطبق بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        $categories = Category::all();
        return view('admin.dishes.edit', compact('dish', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dish $dish)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($dish->image) {
                Storage::disk('public')->delete($dish->image);
            }
            $validated['image'] = $request->file('image')->store('dishes', 'public');
        }

        $dish->update($validated);

        return redirect()->route('admin.dishes.index')
            ->with('success', 'تم تحديث الطبق بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        // Delete image if exists
        if ($dish->image) {
            Storage::disk('public')->delete($dish->image);
        }

        $dish->delete();

        return redirect()->route('admin.dishes.index')
            ->with('success', 'تم حذف الطبق بنجاح');
    }
}
