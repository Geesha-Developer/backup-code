@section('content')
@extends('layouts.broker.app')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
    <i class="fa fa-check"></i>
  <h4 class="alert-heading"><b>Well done!</b></h4>
  <p>Your Customer has been edit successfully!</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <button type="button" class="btn btn-success" onclick="$('.alert').alert('close');">OK</button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorMessage">
  <i class="fa fa-warning"></i>
  <h4 class="alert-heading"><b>Error!</b></h4>
  <p>{{ session('error') }}</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <button type="button" class="btn btn-danger" onclick="$('.alert').alert('close');">OK</button>
</div>
@endif

<style>
    button.close {
        position: absolute;
        right: 14px;
        color: #000;
        top: 8px !important;
        font-size: 32px;
    }

    button#hideFormButton {
        float: right;
    }
</style>

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>Edit Customer</h2>
        </div>
       <div class="card">
        <form method="POST" action="{{ route('customer.update', $customer->id) }}" id="myForm" class="hide" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="card-body text-left">
                <div class="row">
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Customer Name <code>*</code></label>
                          <input class="form-control select2" type="text" required name="customer_name" id="customer_name" style="width: 100%;height:30px ;padding: 0px 0 0 10px; " value="{{ $customer->customer_name }}">
                      </div>
                  </div>
                  <input type="text" name="user_id" hidden>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="mr-2">MC# /FF# 
                              <!-- <code id="mc_ff_code" style="display: none;">*</code> -->
                          </label>
                          <div class="d-flex" style="width: 100%;">
                          <select style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 9px; line-height: 0.2em; color: #666; width: 25% !important; height:30px !important" 
                                    class="form-control select2 mr-2" 
                                    name="customer_mc_ff" 
                                    id="customer_mc_ff">
                                <option value="NA" {{ $customer->customer_mc_ff == 'NA' ? 'selected' : '' }} 
                                        style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;">
                                    NA
                                </option>
                                <option value="MC" {{ $customer->customer_mc_ff == 'MC' ? 'selected' : '' }} 
                                        style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;">
                                    MC
                                </option>
                                <option value="FF" {{ $customer->customer_mc_ff == 'FF' ? 'selected' : '' }} 
                                        style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;">
                                    FF
                                </option>
                            </select>

                              <input class="form-control select2" name="customer_mc_ff_input" id="customer_mc_ff_input" style="width: 100%; height:30px !important;">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Address <code>*</code></label>
                          <input type="text" class="form-control select2" required
                              name="customer_address" id="customer_address"
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; "  value="{{ $customer->customer_address }}">
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Country<code>*</code></label>
                        <select
                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                            class="form-control select2" name="carrier_country" id="country">
                            <option
                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;"
                                selected="selected">Please Select</option>
                            @foreach($countries as $c)
                            <option
                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;"
                                value="{{$c->id}} {{ $c->name }}">{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label>State <code>*</code></label>
                          <div>
                              <select
                                  style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                                  class="form-control select2" required
                                  name="customer_state" id="state">
                                  <!-- <option
                                      style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                      selected="selected" class="hiddenOption">
                                      Please Select
                                  </option> -->
                                  <option value="Please Select" selected>Please Select</option>
                                  
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>City <code>*</code></label>
                          <input type="text" class="form-control select2" required
                              name="customer_city" id="customer_city" value="{{ $customer->customer_city }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Zip <code>*</code></label>
                          <input type="text" class="form-control select2"
                              required name="customer_zip" id="customer_zip" value="{{ $customer->customer_zip }}" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="form-group d-flex align-items-center">
                        <input class="form-control select2" type="checkbox"
                        name="same_as_physical" id="same_as_physical"
                        style="width: 15px;margin-right: 10px;margin-top: 12px;margin-bottom: 17px;padding: 0px 0 0 10px; ">
                        <label class="one-line-label"
                            style="white-space: nowrap;margin-right: 6px;margin-bottom: 5px;">Same
                            as Physical
                            Address</label>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Billing Address <code>*</code></label>
                          <input type="text" class="form-control select2" required type="text" name="customer_billing_address" id="customer_billing_address" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Billing City <code>*</code></label>
                          <input type="text" class="form-control select2" required
                              name="customer_billing_city"
                              id="customer_billing_city"
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Billing State <code>*</code></label>
                          <input type="text" class="form-control select2" required
                              name="customer_billing_state"
                              id="customer_billing_state"
                              style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Billing Zip <code>*</code></label>
                          <input type="text" class="form-control select2"
                              required name="customer_billing_zip"
                              id="customer_billing_zip"
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Billing Country <code>*</code></label>
                          <input type="text" class="form-control select2" required
                              type="text" name="customer_billing_country"
                              id="customer_billing_country"
                              style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>POC Name</label>
                          <input type="text" class="form-control select2" name="customer_primary_contact" value="{{ $customer->customer_primary_contact }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Telephone <code>*</code></label>
                          <input type="number" maxlimit="12"
                              class="form-control select2" required
                              name="customer_telephone" id="customer_telephone" value="{{ $customer->customer_telephone }}"
                              style="width: 100%; height: 30px; padding: 0px 0 0 10px;" />
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Extn. </label>
                          <input type="text" class="form-control select2"
                              name="customer_extn" value="{{ $customer->customer_extn }}"
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Email <code>*</code></label>
                          <input type="email" class="form-control select2"
                              required name="customer_email" value="{{ $customer->customer_email }}"
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="form-group">
                          <label>Website URL </label>
                          <input class="form-control select2"
                              name="adv_customer_webiste_url" value="{{ $customer->adv_customer_webiste_url }}"
                              id="adv_customer_webiste_url"
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Fax</label>
                          <input type="text" class="form-control select2"
                              name="customer_fax" value="{{ $customer->customer_fax }}"
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Acc Pay Email</label>
                          <input type="email" class="form-control select2"
                              name="customer_secondary_email" value="{{ $customer->customer_secondary_email }}"
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; "
                              >
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>AP Contact</label>
                          <input type="number" class="form-control select2"
                              name="customer_billing_telephone" value="{{ $customer->customer_billing_telephone }}"
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>AP Extn.</label>
                          <input type="text" class="form-control select2" name="customer_billing_extn" value="{{ $customer->customer_billing_extn }}" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group align-items-center">
                        <label class="mr-2">Status <code>*</code></label>
                        <div>
                            <select
                                style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 9px; line-height: 0.2em; color: #666; width: 100%; height:30px; padding: 0px 0 0 10px;"
                                class="form-control select2" required name="customer_status">
                                <option style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;" value="">
                                    Please Select
                                </option>
                                <option
                                    style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;"
                                    value="Active" {{ $customer->customer_status == 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option
                                    style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;"
                                    value="In-Active" {{ $customer->customer_status == 'In-Active' ? 'selected' : '' }}>
                                    In-Active
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                </div>
                <div class="card-header mt-3">
                    <h3 class="card-title head"><b>ADVANCED</b></h3>
                </div>
                <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Currency Setting </label>
                        <div class="d-flex" style="width: 100%; height: 30px;">
                            <select class="form-control select2 mr-2"
                                style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666; width: 100%; height: 30px;"
                                name="adv_customer_currency_Setting">
                                <option value=""
                                    style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;"
                                    >Please Select
                                </option>
                                <option value="USD" 
                                    style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;"
                                    {{ $customer->adv_customer_currency_Setting == 'USD' ? 'selected' : '' }}>
                                    American Dollars
                                </option>
                                <option value="CAD"
                                    style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;"
                                    {{ $customer->adv_customer_currency_Setting == 'CAD' ? 'selected' : '' }}>
                                    Canadian Dollars
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Payment Terms</label>
                        <div class="d-flex" style="width: 100%;">
                            <div class="d-flex" style="width: 100%;">
                                <select class="form-control select2"
                                    name="adv_customer_payment_terms"
                                    style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;height:30px"
                                    onchange="showInput()">
                                    <option value="">Please Select</option>
                                    <option value="Net 30" {{ $customer->adv_customer_payment_terms == 'Net 30' ? 'selected' : '' }}>Net 30</option>
                                    <option value="Quick Pay 6% 1 Day" {{ $customer->adv_customer_payment_terms == 'Quick Pay 6% 1 Day' ? 'selected' : '' }}>Quick Pay 6% 1 Day</option>
                                    <option value="Quick Pay 4% 5 Days" {{ $customer->adv_customer_payment_terms == 'Quick Pay 4% 5 Days' ? 'selected' : '' }}>Quick Pay 4% 5 Days</option>
                                    <option value="Prepay" {{ $customer->adv_customer_payment_terms == 'Prepay' ? 'selected' : '' }}>Prepay</option>
                                    <option value="Custom" {{ $customer->adv_customer_payment_terms == 'Custom' ? 'selected' : '' }} id="custome">Custom</option>
                                </select>
                                <input class="form-control select2"
                                    name="adv_customer_payment_terms_custome"
                                    style="width: 100%; height: 30px; display: {{ $customer->adv_customer_payment_terms == 'Custom' ? 'block' : 'none' }};"
                                    id="custome_input"
                                    value="{{ $customer->adv_customer_payment_terms_custome }}">
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Credit Limits</label>
                          <input class="form-control select2" type="number" value="{{ $customer->remaining_credit}}" name="adv_customer_credit_limit" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Sales Rep. <code>*</code></label>
                          <input type="text" class="form-control select2"
                              name="adv_customer_sales_rep"
                              value="{{ auth()->user()->name }}" readonly
                              style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label
                              class="control-label mb-1 el_min100">Duplicate</label>
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox"
                                      id="AddAsShipper" name="AddAsShipper">
                                  <label class="form-check-label"
                                      for="AddAsShipper"
                                      style="font-size:10px;">Add as
                                      Shipper</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox"
                                      id="AddAsConsignee" name="AddAsConsignee">
                                  <label class="form-check-label"
                                      for="AddAsConsignee"
                                      style="font-size:10px;">Add as
                                      Consignee</label>
                              </div>
                      </div>
                  </div>
                  <div class="col-md-5">
                      <div class="form-group align-items-center">
                          <label style="line-height: 1.2em;">Internal Notes
                          </label>
                          <textarea class="form-control select2" type="text" style="height:unset !important;"
                              name="adv_customer_internal_notes"
                              id="adv_customer_internal_notes">{{ $customer->adv_customer_internal_notes }}</textarea>
                      </div>
                  </div>
                  <div class="col-md-5">
                      <div class="form-group">
                          <label style="line-height: 1.2em;">Upload files</label>
                           <input type="file" class="form-control select2" itype="file" id="upload" multiple for="upload" style="padding: 14px 16px;height: unset !important;">
                          <p>Please upload the file you want to share</p>
                      </div>
                  </div>
                </div>
                <div class="text-center mt-2 mb-3">
                    <input type="submit" class="btn btn-info" value="Save">
                    <input type="button" class="btn btn-danger" data-dismiss="modal"
                        value="Cancel">
                </div>
              </div>
          </form>
       </div>
    </div>
</section>

@endsection