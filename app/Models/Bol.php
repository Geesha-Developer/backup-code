<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bol extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bol_number',
        'carrier_name',
        'freight_charges',
        'pickup_locations',
        'drop_locations',
        'bill_of_lading_qty',
        'bill_of_lading_weight',
        'items',
        'files_print',
        'pieces',
        'description',
        'lbs',
        'type',
        'nmfc',
        'hm',
        'class',
    ];
}
