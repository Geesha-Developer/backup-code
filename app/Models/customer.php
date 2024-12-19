<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = ['customer_name','customer_id	','customer_mc_ff','customer_mc_ff_input','customer_address','customer_country','customer_state','customer_city','customer_zip','customer_billing_address','customer_billing_country','customer_billing_state','customer_billing_city','customer_billing_zip','customer_primary_contact','customer_telephone','customer_extn','customer_email','customer_tollfree','customer_fax','customer_secondary_contact','customer_secondary_email','customer_billing_email','customer_billing_telephone','customer_billing_extn','customer_blacklisted','customer_corporation','adv_customer_mc_ff','adv_customer_input','adv_customer_credit_limit','adv_customer_payment_terms','adv_customer_payment_terms_input','adv_customer_sales_rep','adv_customer_factoring_company','adv_customer_federal_id','adv_customer_worker_camp','adv_customer_webiste_url','adv_customer_number_invoice','adv_customer_duplicate','adv_customer_duplicate_two','adv_customer_internal_notes','quote_customer_rate_type','quote_customer_fsc_type','quote_customer_fsc_rate','user_id','comment_notes','commenter_name','status','remaining_credit','approved_limit'];

        // Define the relationship with the User model
        public function user()
        {
            return $this->belongsTo(User::class);
        }
        // Customer.php (Model)
        public function loads()
        {
            return $this->hasMany(Load::class, 'user_id', 'user_id');
        }

        protected static function boot()
        {
            parent::boot();
        
            // When a new load is created, deduct the amount from the customer's remaining_credit
            static::created(function ($load) {
                $load->deductCustomerCredit();
            });
        
            // When a load is deleted, adjust the customer's remaining_credit
            static::deleted(function ($load) {
                $load->adjustCustomerCreditOnDeletion();
            });
        
            // When invoice status is updated to 'Paid Record', restore the remaining_credit
            static::updated(function ($load) {
                if ($load->isDirty('invoice_status') && $load->invoice_status == 'Paid Record') {
                    $load->restoreCustomerCreditOnPayment();
                }
            });
        }
        
        public function deductCustomerCredit()
        {
            $customer = Customer::find($this->customer_id);
        
            if ($customer) {
                // Only deduct from remaining_credit, do not touch adv_customer_credit_limit
                $customer->remaining_credit -= $this->shipper_load_final_rate;
                $customer->remaining_credit_amount -= $this->shipper_load_final_rate;
                // Ensure remaining_credit doesn't go below zero
                $customer->remaining_credit = max($customer->remaining_credit, 0);
                $customer->remaining_credit_amount = max($customer->remaining_credit_amount, 0);
        
                // Save the updated customer data
                $customer->save();
            }
        }
        
        public function adjustCustomerCreditOnDeletion()
        {
            $customer = Customer::find($this->customer_id);
        
            if ($customer) {
                // Only restore remaining_credit when a load is deleted
                $customer->remaining_credit += $this->shipper_load_final_rate;
                $customer->remaining_credit_amount += $this->shipper_load_final_rate;
                // Save the updated customer data
                $customer->save();
            }
        }
        
        public function restoreCustomerCreditOnPayment()
        {
            $customer = Customer::find($this->customer_id);
        
            if ($customer) {
                // Restore remaining_credit on invoice payment
                $customer->remaining_credit += $this->shipper_load_final_rate;
                $customer->remaining_credit_amount += $this->shipper_load_final_rate;
                // Save the updated customer data
                $customer->save();
            }
        }
        
        
        
        






        
}

