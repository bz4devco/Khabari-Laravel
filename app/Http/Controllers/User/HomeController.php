<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Content\Banner;
use App\Models\Content\ReportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $mainSlider = Banner::activeSliderBanner()->get();

        $mainCategories = ReportCategory::activeReports()->get();

        $categoriesSlider = ReportCategory::activeCatecoriesForSlider()->get();

        $contentBanner = Banner::activeContentBanner()->first();

        $categoriesSlider = ReportCategory::activeCatecoriesForSlider()->get();

        $mainCategoryReports = ReportCategory::activeReports()->get();


        return view('frontend.index', compact('mainSlider', 'mainCategories', 'categoriesSlider', 'contentBanner', 'categoriesSlider', 'mainCategoryReports'));
    }
}
