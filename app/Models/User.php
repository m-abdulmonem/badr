<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'f_name',
        'l_name',
        'm_name',
        'email',
        'phone',
        'otp_code',
        'status',
        'password',
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
        'email_verified_at' => 'datetime',
    ];




    public function images()
    {
        return $this->hasMany(ProfileImage::class);
    }


    public function license()
    {
        return $this->hasMany(AcademicLicense::class);
    }






    public function scopeIsAdmin($q)
    {
        return $this->is_admin == 1;
    }

    public function scopeIsActive($q)
    {
        return $this->status == 1;
    }

}
