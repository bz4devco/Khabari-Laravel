<?php

namespace App\Models;

use App\Models\Content\Report;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'body', 'parent_id	', 'author_id', 'commentable_id', 'commentable_type', 'seen', 'approved', 'status'
    ];


    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }


    public function parent()
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }

    
    public function commentable()
    {
        return $this->morphTo();
    }


    public function scopeActivesidbarComments($query)
    {
        $query->where('commentable_type', 'App\Models\Content\Report')->where('status', 1)->where('approved', 1)->latest()->take(2);
    }

}
