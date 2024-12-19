<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McCheck extends Model
{
    use HasFactory;

    protected $table = 'mc_check';

    protected $fillable = [
        'user_id',
        'carrier_name',
        'carrier_dot',
        'carrier_mc_ff_input',
        'carrier_email',
        'carrier_telephone',
        'carrier_commodity_type',
        'carrier_commodity_name',
        'carrier_commodity_value',
        'carrier_equipment_type',
        'carrier_mc_purpose',
        'carrier_commodity_value_proof',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
