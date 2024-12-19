<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\customer;
use App\Models\External;

class Load extends Model
{
    use HasFactory;

    protected $table = 'load';
    
    protected $fillable = [
        'load_number', 'load_dispatcher', 'load_bill_to', 'load_status', 'load_workorder', 'load_payment_type', 
        'load_type', 'load_shipper_rate', 'load_pds', 'load_fsc_rate', 'load_telephone', 'load_other_change', 
        'load_final_rate', 'load_carrier', 'load_advance_payment', 'load_type_two', 'load_billing_type', 
        'load_mc_no', 'load_equipment_type', 'load_carrier_fee', 'load_currency', 'load_pds_two', 
        'load_billing_fsc_rate', 'load_other_charge', 'load_final_carrier_fee', 'load_other_charge_two', 
        'user_id', 'invoice_status', 'comment_notes', 'private_file', 'public_file', 'load_actual_delivery_date', 
        'load_carrier_due_date', 'load_carrier_due_date_on', 'carrier_mark_as_paid', 'load_carrier_phone', 
        'shipper_load_final_rate', 'load_consignee_contact', 'receiving_amount', 'cpr_check', 'customer_id',
        'comment', 'carrierDoc', 'carrier_dot', 'carrier_id', 'internal_notes','invoicing_payment_terms'
    ];


    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id', 'user_id');
    }
    


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function carrier()
    {
        return $this->belongsTo(External::class, 'carrier_id', 'id');
    }

    protected $casts = [
        'load_shipper_date' => 'datetime',
    ];



    protected static function boot()
    {
        parent::boot();
    
        // When a new load is created, deduct the amount from the customer's remaining credit
        static::created(function ($load) {
            $load->deductCustomerCredit();
        });
    
        // When a load is updated, specifically check if the invoice status has changed to 'Paid Record'
        static::updated(function ($load) {
            if ($load->isDirty('invoice_status') && $load->invoice_status == 'Paid Record') {
                $load->restoreCustomerCreditOnPayment();
            }
        });
    
        // When a load is deleted, adjust the customer's remaining credit
        static::deleted(function ($load) {
            $load->adjustCustomerCreditOnDeletion();
        });
    }
    
    // Deduct the load amount from the customer's remaining credit
    public function deductCustomerCredit()
    {
        $customer = customer::find($this->customer_id);
    
        if ($customer) {
            // Deduct the shipper_load_final_rate from remaining credit only
            $customer->remaining_credit -= $this->shipper_load_final_rate;
    
            // Ensure remaining credit doesn't go below 0
            if ($customer->remaining_credit < 0) {
                $customer->remaining_credit = 0;
            }
    
            $customer->save();
        }
    }
    
    // Restore customer credit when the invoice status changes to 'Paid Record'
    public function restoreCustomerCreditOnPayment()
    {
        $customer = customer::find($this->customer_id);
    
        if ($customer) {
            // Restore the amount back to remaining credit only
            $customer->remaining_credit += $this->shipper_load_final_rate;
            $customer->save();
        }
    }
    
    // Adjust remaining credit when a load is deleted
    public function adjustCustomerCreditOnDeletion()
    {
        $customer = customer::find($this->customer_id);
    
        if ($customer) {
            // Restore the amount back to remaining credit only
            $customer->remaining_credit += $this->shipper_load_final_rate;
            $customer->save();
        }
    }
    
    // Update customer credit directly (if needed elsewhere)
    public function updateCustomerCredit()
    {
        $customer = customer::find($this->customer_id);
    
        if ($customer) {
            // Deduct the shipper_load_final_rate from the customer's remaining credit only
            $customer->remaining_credit -= $this->shipper_load_final_rate;
    
            // Ensure the remaining credit doesn't go below zero
            if ($customer->remaining_credit < 0) {
                $customer->remaining_credit = 0;
            }
    
            $customer->save();
        }
    }
    

    
}
