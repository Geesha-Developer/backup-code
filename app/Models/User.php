<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'office', 'manager', 'team_lead','emergency_contact','emp_code','profile_picture',
    ];

    public function profileData()
    {
        return $this->hasOne(ProfileData::class, 'users_id');
    }
    public function Customer()
    {
        return $this->hasOne(ProfileData::class, 'users_id');
    }
    public function customers()
{
    return $this->hasMany(Customer::class);
}

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

    /**
     * Define the relationship with the External model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function externals()
    {
        return $this->hasMany(External::class);
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}



}
