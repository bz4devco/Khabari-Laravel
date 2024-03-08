<?php

namespace App\Models\Content;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $casts = [
        'image' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $guarded = ['id'];

    public function category()
    {
       return $this->belongsTo('App\Models\Content\ReportCategory', 'category_id');
    }

    public function author()
    {
        return $this->belongsToMany(
            'App\Models\User'
        );
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }


    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function guestComments()
    {
        return $this->morphMany('App\Models\GuestComment', 'commentable');
    }


    public function ScopeActiveHeaderNewReports($query)
    {
        $query->where('status', 1)->where('new_date', '<', Carbon::now())->orderBy('new_date', 'desc')->take(5);
    }

    public function ScopeActiveReportsWithCategory($query, $category, $search)
    {
        $query->when($category, function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })
        ->when($search, function ($query) use ($search) {
            $query->where('title', 'like' , '%' . $search . '%')
            ->where('abstract', 'like' , '%' . $search . '%')
            ->where('body', 'like' , '%' . $search . '%');
        })
        ->where('new_date', '<', Carbon::now());
    }

    public function ScopeActiveHotReports($query)
    {
        $query->where('status', 1)->where('new_date', '<', Carbon::now())->orderBy('visit_counter', 'desc')->take(10);
    }


    public function activeComments()
    {
        return $this->comments()->where('approved', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function activeGuesrComments()
    {
        return $this->guestComments()->where('approved', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
