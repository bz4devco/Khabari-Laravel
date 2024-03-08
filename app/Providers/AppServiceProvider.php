<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Content\Menu;
use App\Models\Content\Banner;
use App\Models\Content\Page;
use App\Models\Content\Report;
use Illuminate\Pagination\Paginator;
use App\Models\Content\ReportCategory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //           ADMIN SECTIONS
        //header admin datas
        view()->composer('admin.layouts.header', function ($view) {
            $view->with('unseenComments', Comment::where('seen', 0)->get());
        });

        /////////////////////////////////////////////////////////////////////////////////////


        //           USER SECTIONS

        // header user datas

        view()->composer('frontend.layouts.header', function ($view) {
            $view->with('headerPages', Page::activeHeaderPages()->get());
            $view->with('headerCateegories', ReportCategory::activeCategories()->where('show_in_menu', 1)->get());
            $view->with('latestReports', Report::activeHeaderNewReports()->get());
            $view->with('headerBanner', Banner::activeHeaderBanner()->get());
        });

        ////////////////////////////////////////

        // footer user datas

        view()->composer('frontend.layouts.footer', function ($view) {
            $view->with('footerCategories', ReportCategory::activeCategories()->where('show_in_menu', 1)->get());
            $view->with('footerMenu', Menu::where('status', 1)->where('position', 1)->orderBy('sort', 'asc')->take(15)->get());
        });

        ////////////////////////////////////////

        // sidebar user datas
        view()->composer(['frontend.*'], function ($view) {
            $view->with('sidebarLatestReports', Report::activeHeaderNewReports()->take(3)->get());
            $view->with('sideBarHotReports', Report::activeHotReports()->get());
            $view->with('sidebarComments', Comment::activesidbarComments()->get());
        });

        /////////////////////////////////////////////////////////////////////////////////////

        // email site setings datas
        view()->composer(['frontend.*', 'emails.*'], function ($view) {
            $view->with('setting', Setting::where('status', 1)->orderBy('id', 'asc')->first());
        });
    }
}
