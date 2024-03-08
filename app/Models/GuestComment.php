<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuestComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'body', 'commentable_id', 'commentable_type', 'seen', 'approved', 'status'
    ];


    public function commentable()
    {
        return $this->morphTo();
    }


    public function scopeActivesidbarComments($query)
    {
        $query->where('commentable_type', 'App\Models\Content\Report')->where('status', 1)->where('approved', 1)->latest()->take(2);
    }
}
