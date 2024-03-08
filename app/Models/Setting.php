<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'settings';

    protected $casts = [
        'logo' => 'array',
        'icon' => 'array',
        'index_page' => 'array',
    ];


    protected $fillable = [
        'title', 'description', 'base_url', 'keywords', 'telegram', 'instagram', 'twitter', 'linkedin', 'google_plus', 'tel', 'email', 'address', 'icon', 'logo', 'google_map', 'status', 'index_page'
    ];
}
