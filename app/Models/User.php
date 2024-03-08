<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'gender',
        'service_status',
        'address',
        'national_code',
        'profile_photo_path',
        'user_type',
        'activation_date',
        'email_verified_at',
        'mobile_verified_at',
        'username',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'address' => 'array',
        'email_verified_at' => 'datetime',
    ];

    public function reports()
    {
        return $this->belongsToMany(
            'App\Models\Content\Report'
        );
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'author_id');
    }


    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    public function scopeActiveUsers()
    {
        return $this->where('activation_date', 'like', '%' . Carbon::now()->format('Y-m-d') . '%')
            ->where('user_type', 0)
            ->where('status', 1)
            ->count();
    }


    public function scopeAdminUsers()
    {
        return $this->where('user_type', 1)->count();
    }


    public function roles()
    {
        return $this->belongsToMany('App\Models\UserRole\Role');
    }


    public function permissions()
    {
        return $this->belongsToMany('App\Models\UserRole\Permission');
    }
}
