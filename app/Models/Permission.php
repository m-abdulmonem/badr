<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['display','create','edit','delete','user_status','user_id'];





    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
