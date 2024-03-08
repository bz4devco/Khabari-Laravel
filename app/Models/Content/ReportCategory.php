<?php

namespace App\Models\Content;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportCategory extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' =>[
                'source' => 'name'
            ]
        ];
    } 

    protected $fillable = [
        'name', 'description', 'show_in_menu', 'status', 'sort'
    ];


    public function reports()
    {
       return $this->hasMany('App\Models\Content\Report', 'category_id');
    }


    public function ScopeActiveCategories($query)
    {
        $query->where('status', 1)->where('show_in_menu', 1)->orderBy('sort', 'asc');
    }

    public function ScopeActiveReports($query)
    {
        $query->with(['reports' => function ($q) {
            $q->where('status', 1)->where('new_date', '<', Carbon::now())->latest();
        }])->orderBy('id', 'asc')->take(5);
    }

    public function ScopeActiveCatecoriesForSlider($query)
    {
        $query->with(['reports' => function ($q) {
            $q->where('status', 1)->where('new_date', '<', Carbon::now())->latest();
        }])->latest()->take(8);
    }
}
