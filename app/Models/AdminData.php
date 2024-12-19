<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminData extends Model
{
    use HasFactory;
    protected $table = 'admins';

    protected $fillable = ['name','email'];
}
