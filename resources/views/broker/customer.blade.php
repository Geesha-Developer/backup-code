@extends('layouts.broker.app')
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check"></i>
  <h4 class="alert-heading"><b>Well done!</b></h4>
  <p>Customer has been added Successfully!</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <button type="button" class="btn btn-success" onclick="$('.alert').alert('close');">OK</button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
    .table>:not(caption)>*>* {
        background-color: unset !important;
    }
    button.close {
        position: absolute;
        right: 14px;
        color: #000;
        top: 11px !important;
        font-size: 32px;
    }
    button#hideFormButton {
    float: right;
    }
    input#customer_telephone::placeholder {
    font-size: 8px;
}
.row-open {
    background-color: #f9e79f !important; / Example color for Open /
}

.row-delivered {
    background-color: #ffcccb !important; / Example color for Delivered /
}
</style>

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>Customer Listing </h2>
        </div>
        <div class="container-fluid p-0">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 p-0">
                    <div class="card">
                        <div class="body">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> ADD CUSTOMER</button>
                            
                            <div class="table-responsive">
                                <table id="dataTableDelivered"
                                    class="table table-bordered table-responsive dataTable no-footer" data-page-length="50">
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <!-- <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div> -->
                                                <form method="POST" action="{{ route('customer_insert') }}" id="myForm" class="hide" enctype="multipart/form-data"> @csrf


                                                    <div class="card-header" style="color: #fff;">
                                                        <h3 class="card-title head">CUSTOMER DETAILS</h3>
                                                        <button type="button" class="close" style="top: -5px;background: red;border-radius: 30px; padding: 0 5px; font-size: 22px;color: #fff;"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>

                                                    <div class="card-body text-left">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Customer Name <code>*</code></label>
                                                                    <input class="form-control select2" type="text" required name="customer_name" id="customer_name"
                                                                        style="width: 100%;height:30px ;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <input type="text" name="user_id" hidden>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="mr-2">MC# /FF# 
                                                                        <!-- <code id="mc_ff_code" style="display: none;">*</code> -->
                                                                    </label>
                                                                    <div class="d-flex" style="width: 100%;">
                                                                        <select style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 9px; line-height: 0.2em; color: #666; width: 45% !important; height:30px !important" class="form-control select2 mr-2" name="customer_mc_ff" id="customer_mc_ff">
                                                                            <option selected="selected" style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;" id="mc_ff_code_na">NA</option>
                                                                            <option style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;" >MC</option>
                                                                            <option style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;">FF</option>
                                                                        </select>
                                                                        <input class="form-control select2" name="customer_mc_ff_input" id="customer_mc_ff_input" style="width: 100%; height:30px !important; display: none;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Address <code>*</code></label>
                                                                    <input type="text" class="form-control select2" required
                                                                        name="customer_address" id="customer_address"
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px;  ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Country <code>*</code></label>
                                                                    <div>
                                                                        <select
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                                                                            class="form-control select2" required
                                                                            name="customer_country" id="country">
                                                                            <option style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;" value="">Choose Country</option>

                                                                            @foreach($countries as $c)
                                                                            <option
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                                value="{{ $c->id }} {{ $c->name }}" data-id="{{ $c->name }}">{{ $c->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
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
                                                                            @foreach($states as $s)
                                                                            
                                                                            <option
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                                value="{{ $s->id }}|{{ $s->name }}">
                                                                                {{$s->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>City <code>*</code></label>
                                                                    <input type="text" class="form-control select2" required
                                                                        name="customer_city" id="customer_city"
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Zip <code>*</code></label>
                                                                    <input type="text" class="form-control select2"
                                                                        required name="customer_zip" id="customer_zip"
                                                                        style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group d-flex align-items-center">
                                                                    <label class="one-line-label"
                                                                        style="white-space: nowrap;margin-right: 6px;margin-bottom: 5px;">Same
                                                                        as Physical
                                                                        Address</label>
                                                                    <input class="form-control select2" type="checkbox"
                                                                        name="same_as_physical" id="same_as_physical"
                                                                        style="width: 15px;height: 30px;margin-top: 12px;margin-bottom: 17px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Billing Address <code>*</code></label>
                                                                    <input type="text" class="form-control select2" required
                                                                        type="text" name="customer_billing_address"
                                                                        id="customer_billing_address"
                                                                        style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
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
                                                                    <input type="text" class="form-control select2" name="customer_primary_contact"
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Phone No <code>*</code></label>
                                                                    <input type="number" maxlimit="12"
                                                                        class="form-control select2" required
                                                                        name="customer_telephone" id="customer_telephone"
                                                                        style="width: 100%; height: 30px; padding: 0px 0 0 10px;" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Extn. </label>
                                                                    <input type="text" class="form-control select2"
                                                                        name="customer_extn"
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Email <code>*</code></label>
                                                                    <input type="email" class="form-control select2"
                                                                        required name="customer_email"
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label>Website URL </label>
                                                                    <input class="form-control select2"
                                                                        name="adv_customer_webiste_url"
                                                                        id="adv_customer_webiste_url"
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Fax</label>
                                                                    <input type="text" class="form-control select2"
                                                                        name="customer_fax"
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Acc Pay Email</label>
                                                                    <input type="email" class="form-control select2"
                                                                        name="customer_secondary_email"
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px; "
                                                                        >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>AP Contact</label>
                                                                    <input type="number" class="form-control select2"
                                                                        name="customer_billing_telephone"
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>AP Extn.</label>
                                                                    <input type="text" class="form-control select2" name="customer_billing_extn" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group align-items-center">
                                                                    <label class="mr-2">Status <code>*</code></label>
                                                                    <div>
                                                                        <select
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px; "
                                                                            class="form-control select2" required
                                                                            name="customer_status">
                                                                            <option style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;" value="">
                                                                                Please Select
                                                                            </option>
                                                                            <option
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;">
                                                                                Active</option>
                                                                            <option
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;">
                                                                                In-Active</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-header mt-3">
                                                        <h3 class="card-title head">ADVANCED</h3>
                                                    </div>
                                                    <div class="card-body text-left">
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
                                                                            <option
                                                                                style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;">
                                                                                American Dollars
                                                                            </option>
                                                                            <option
                                                                                style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;">
                                                                                Canadian Dollars
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Payment Terms</label>
                                                                    <div class="d-flex" style="width: 100%;  ">
                                                                        <div class="d-flex" style="width: 100%;  ">
                                                                            <select class="form-control select2"
                                                                                name="adv_customer_payment_terms"
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;height:30px"
                                                                                onchange="showInput()">
                                                                                <option value="">Please Select</option>
                                                                                <option value="Net 30">Net30
                                                                                </option>
                                                                                <option value="Quick Pay 6% 1 Day">
                                                                                    Quick Pay
                                                                                    6% 1 Day</option>
                                                                                <option value="Quick Pay 4% 5 Days">
                                                                                    Quick
                                                                                    Pay 4% 5 Days</option>
                                                                                <option value="Prepay">Prepay
                                                                                </option>
                                                                                <option value="Custom" id="custome">
                                                                                    Custom
                                                                                </option>
                                                                            </select>
                                                                            <input class="form-control select2"
                                                                                name="adv_customer_payment_terms_custome"
                                                                                style="width: 100%; height: 30px; display: none;"
                                                                                id="custome_input">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Credit Limits</label>
                                                                    <input class="form-control select2" type="number" name="adv_customer_credit_limit" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div> -->
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
                                                                    <textarea class=" select2" type="text"
                                                                        name="adv_customer_internal_notes"
                                                                        id="adv_customer_internal_notes"
                                                                        style="width: 100%; height:47px;border:1px solid #ccc"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label style="line-height: 1.2em;">Upload files</label>
                                                                    <label for="upload" class="upload-button" style="height: 47px;">
                                                                        <input type="file" id="upload" multiple>
                                                                        <p class="choose-file" style="font-size: 12px;">Choose the file</p>
                                                                        </label> 
                                                                    <p>Please upload the file you want to share</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="submit" class="btn btn-info" value="Save">
                                                            <input type="button" style="font-size:14px !important;"  class="btn btn-warning" id="clearFormButton" Value="Clear Form">
                                                            <input type="button" class="btn btn-danger" data-dismiss="modal"
                                                                value="Cancel">
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <thead>

                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Customer Name</th>
                                            <th>Address</th>
                                            <th>Phone No</th>
                                            <th>Added Date</th>
                                            <th>Agent</th>
                                            <th>Team Leader</th>
                                            <th>Manager</th>
                                            <!-- <th>Total Credit Limit</th> -->
                                            <th>Credit Used</th>
                                            <th>Remaning Credit</th>
                                            <th>Last Load</th>
                                            <th>Approved Status</th>
                                            <th>Comment / Notes</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp    
                                        @foreach($customers as $customer)
                                        <tr class="load-row {{ $customer->status == 'Approved' ? 'row-open' : ($customer->status != 'Approved' ? 'row-delivered' : '') }}">
                                                <td class="dynamic-data">{{ $i++ }}</td>
                                                <td class="dynamic-data">{{ $customer->customer_name }}</td>
                                                <td class="dynamic-data">
                                                    {{ $customer->customer_address }} 
                                                    {{ $customer->customer_country }} 
                                                    {{ $customer->customer_state }} 
                                                    {{ $customer->customer_city }} 
                                                    {{ $customer->customer_zip }}
                                                </td>
                                                <td class="dynamic-data">{{ $customer->customer_telephone }}</td>
                                                
                                                
                                                
                                                <td class="dynamic-data">{{ $customer->created_at->format('m-d-Y') }}</td>
                                                <td class="dynamic-data">{{ $customer->user->name }}</td>
                                                <td class="dynamic-data">{{ $customer->user->team_lead }}</td>
                                                <td class="dynamic-data">{{ $customer->user->manager }}</td>
                                                
                                                <!-- <td class="dynamic-data">
                                                    @if($customer->status == 'Approved')
                                                        ${{ $customer->adv_customer_credit_limit }}
                                                    @else
                                                        xxx
                                                    @endif
                                                </td> -->
                                                @php
                                                    $sumOfShipperLoadFinalRate = \App\Models\Load::where('customer_id', $customer->id)->sum('shipper_load_final_rate');
                                                @endphp

                                                <td class="dynamic-data">
                                                    ${{ number_format($sumOfShipperLoadFinalRate, 2) }}
                                                </td>

                                                <td class="dynamic-data">
                                                    @if($customer->status == 'Approved')
                                                        ${{ $customer->remaining_credit_amount }}
                                                    @else
                                                        xxx
                                                    @endif
                                                </td>
                                                <td class="dynamic-data">{{ $customer->aging_days !== null ? $customer->aging_days . ' days' : 'N/A' }}</td> <!-- Displaying the aging days -->
                                                
                                                <td class="dynamic-data">
                                                    {{ $customer->status == 'Approved' ? 'Approved' : 'Pending For Approval' }}
                                                </td>
                                                <td class="dynamic-data">
                                                    @if($customer->commenter_name)
                                                        @php
                                                            // Decode the JSON strings
                                                            $commenterNames = json_decode($customer->commenter_name, true);
                                                            $commentNotes = json_decode($customer->comment_notes, true);

                                                            // Initialize an empty string for comments
                                                            $comments = '';

                                                            // Check if the decoding was successful and both are arrays
                                                            if (is_array($commenterNames) && is_array($commentNotes)) {
                                                                for ($j = 0; $j < count($commenterNames); $j++) {
                                                                    // Concatenate comments if indexes exist
                                                                    if (isset($commenterNames[$j]) && isset($commentNotes[$j])) {
                                                                        $comments .= $commenterNames[$j] . ': ' . $commentNotes[$j] . "\n";
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        <textarea disabled name="comment_text" id="comment_text" rows="1">{{ $comments }}</textarea>
                                                    @else
                                                        <textarea disabled name="comment_text" rows="1">No Comment Found</textarea>
                                                    @endif
                                                    @if($customer->status != 'Approved')
                                                    <td>
                                                        <a href="{{ route('customer.edit', $customer->id) }}"><i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i></a>
                                                    </td>
                                                    @else
                                                    <td>Approved</td>
                                                    @endif

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        // Attach keydown event listener to the input field with ID customer_telephone
        $('#customer_telephone').on('keydown', function (event) {
            // Get the pressed key code
            var keyCode = event.keyCode || event.which;

            // Allow only numeric keys (0-9)
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 8 && keyCode !== 9 && keyCode !== 37 &&
                keyCode !== 39 && keyCode !== 46) {
                // Prevent the default action of the key event
                event.preventDefault();
                // Alert the user
                alert("Special characters are not allowed.");
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Retrieve the last active tab from local storage
        var lastActiveTab = localStorage.getItem('lastActiveTab');

        // If a last active tab is found, set it as active
        if (lastActiveTab) {
            $('#myTab a[href="' + lastActiveTab + '"]').tab('show');
        }

        // Store the active tab in local storage when a tab is clicked
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetTab = e.target.getAttribute('href');
            localStorage.setItem('lastActiveTab', targetTab);
        });

        // Initialize DataTables for both tables
        $('#dataTableOpen').DataTable();
        $('#dataTableDelivered').DataTable();
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Inject CSS dynamically via JavaScript
        var style = '<style>' +
                        'tbody tr.highlight-row {' +
                            'background-color: #CAF1EB !important;' +
                        '}' +
                    '</style>';
        $('head').append(style); // Append the style to the head

        // Event delegation to target the first <td> in each row
        $('tbody').on('click', 'td', function() {
            // Remove the highlight from any previously selected row
            $('tbody tr').removeClass('highlight-row');
            
            // Add highlight to the clicked row
            $(this).closest('tr').addClass('highlight-row');
        });
    });
</script>
<script>
$(document).ready(function () {
    // Function to clear all form data
    function clearFormData() {
        $('#myForm')[0].reset(); // Reset the form
    }
// Clear form button click event
    $('#clearFormButton').on('click', function() {
        clearFormData(); // Call the clear form function
    });
});
</script>
@endsection