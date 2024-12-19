<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;

    protected $table = 'shippers';

    protected $fillable = ['shipper_name','shipper_address','shipper_country','shipper_state','shipper_city','shipper_zip','shipper_contact_name','shipper_contact_email','shipper_telephone','shipper_extn','shipper_toll_free','shipper_fax','shipper_hours','shipper_appointments','shipper_major_intersections','shipper_status','shipper_shipping_notes','shipper_internal_notes','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
