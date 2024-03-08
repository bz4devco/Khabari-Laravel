<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'image', 'body', 'url', 'position', 'status', 'sort'
    ];

    public static $positions = [
        0 => 'اسلایدشو (صفحه اصلی)',
        1 => 'بنر هدر (صفحه اصلی)',
        2 => 'اسلایدشو دسته بندی (صفحه اصلی)',
        3 => 'بنر انتهایی (صفحه اصلی)',
    ];


    public function ScopeActiveHeaderBanner($query)
    {
        $query->where('position', 1)->where('status', 1)->orderBy('sort', 'asc');
    }



    public function ScopeActiveSliderBanner($query)
    {
        $query->where('position', 0)->where('status', 1)->orderBy('sort', 'asc')->take(5);
    }

    public function ScopeActiveContentBanner($query)
    {
        $query->where('position', 3)->where('status', 1)->orderBy('sort', 'asc');
    }

    public function activeCategorysBanner()
    {
        return $this->where('position', 2)->where('status', 1)->orderBy('sort', 'asc')->take(8)->get();
    }
}
