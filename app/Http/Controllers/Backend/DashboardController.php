<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Service;
use App\Models\HeroStory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalEnquiries = Enquiry::count();
        $unreadEnquiries = Enquiry::whereNull('read_at')->count();
        $recentEnquiries = Enquiry::latest()->take(5)->get();
        $thisWeek = Enquiry::where('created_at', '>=', now()->startOfWeek())->count();
        $productCount = Product::where('is_active', true)->count();
        $serviceCount = Service::where('is_active', true)->count();
        $heroStoryCount = HeroStory::where('is_active', true)->count();

        return view('backend.pages.dashboard', compact(
            'totalEnquiries',
            'unreadEnquiries',
            'recentEnquiries',
            'thisWeek',
            'productCount',
            'serviceCount',
            'heroStoryCount',
        ));
    }
}
