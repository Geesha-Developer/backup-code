<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manger extends Model
{
    use HasFactory;
    protected $table = 'manager';
    protected $primaryKey = 'id';
    
    protected $fillable = ['manager','leader_email','leader_manager','office'];
}
