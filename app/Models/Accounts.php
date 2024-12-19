<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $table = 'accountslogin';

    protected $fillable = ['name','email','password','manager','team_lead','role'];

        // Define the relationship with the User model
}

