<?php

// app/Models/AdminUser.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $table = 'admin_users'; // if the table name is 'admin_users'

    // Assuming you have a 'role' field in your 'admin_users' table
    public function isAdmin()
    {
        return $this->role === 'super_admin'; // Assuming 'super_admin' is the role for the super admin
    }

    // Add more custom logic or relationships here
}
