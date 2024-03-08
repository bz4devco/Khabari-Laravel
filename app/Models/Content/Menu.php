<?php

namespace App\Models\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

   
    protected $fillable = [
        'name', 'url', 'parent_id', 'status', 'sort', 'position'
    ];


    public static $positions = [
        0 => 'نمایش در هدر',
        1 => 'نمایش در فوتر',
    ];


    public function parent()
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }


    public function children()
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }

}
