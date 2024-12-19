<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignee extends Model
{
    use HasFactory;

    protected $table = 'consignee';

    protected $fillable = ['consignee_name','consignee_address','consignee_country','consignee_state','consignee_city','consignee_zip','consignee_contact_name','consignee_contact_email','consignee_telephone','consignee_ext','consignee_toll_free','consignee_fax','consignee_hours','consignee_appointments','consignee_major_intersections','consignee_status','consignee_internal_notes','consignee_shipping_notes','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
