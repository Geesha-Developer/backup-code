<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileData extends Model
{
protected $fillable = ['users_id', 'employee_code', 'employee_bio', 'employee_mobile', 'employee_facebook', 'employee_linkedin', /* other columns in the profile_data table */];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}