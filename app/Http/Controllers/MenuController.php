<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display the menu page.
     */
    public function index()
    {
        $categories = Category::with('dishes')->orderBy('order')->get();
        $currency = \App\Models\Setting::getValue('currency', 'ر.س');
        
        return view('menu.index', compact('categories', 'currency'));
    }
}
