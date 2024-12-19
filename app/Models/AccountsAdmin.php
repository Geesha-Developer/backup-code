<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsAdmin extends Model
{
    use HasFactory;

    protected $table = 'accountslogin';

    protected $fillable = ['name', 'email', 'password'];
}
