<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $categoriesCount = Category::count();
        $dishesCount = Dish::count();
        
        // Generate QR code for menu (using SVG to avoid imagick requirement)
        $menuUrl = url('/');
        $qrCodeSvg = QrCode::format('svg')->size(200)->generate($menuUrl);
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        return view('admin.dashboard', compact('categoriesCount', 'dishesCount', 'qrCode', 'menuUrl'));
    }
}
