<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicLicense extends Model
{
    use HasFactory;


    protected $fillable = ['license' ,'user_id'];
}
