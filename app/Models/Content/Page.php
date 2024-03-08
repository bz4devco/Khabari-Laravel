<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' =>[
                'source' => 'url'
            ]
        ];
    } 

    protected $fillable = [
        'title', 'url', 'body', 'status', 'tags'
    ];


    public function ScopeActiveHeaderPages($query)
    {
        $query->where('status', 1)->latest()->take(4);
    }
}
