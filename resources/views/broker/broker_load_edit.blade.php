@extends('layouts.broker.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM8/6iZRv4r9jcv3a0RV9x4dAF7URy0vOGm6wvT" crossorigin="anonymous">

@if(session('success'))
<div class="alert alert-success" id="successMessage">
    {{ session('success') }}
</div>
@endif

<style>

    .card-title {
        font-size: 13px;
        text-align: left;
        font-weight: 700;
    }
    .card-body .form-group {
    margin: 19px 0 4px 0;
}
    .modal-content {
        padding: 12px 12px !important;
    }

    .nav {
        align-items: end;
        justify-content: left;
        width: 100%;
    }

    .card-body1 .form-group label {
        margin-bottom: 4px;
        font-weight: 600;
        font-size: 13px;
        text-align: left;
        color: #4a4a4a;
    }

    .card-body {
        padding: 0;
    }

    .item {
        border: 1px solid #b4bbc1;
        padding: 3px;
        margin: 5px 0 0 0px;
    }

    #consigneeSections .nav li a {
        color: #000 !important;
        background: unset;
        border: unset !important;
        font-size: 12px;

    }


    #consigneeSections .nav li {
        border: 1px solid #ccc;
        padding: 3px 4px;
        border-radius: 10px;
        background: #fff;
        margin-right: 10px;
        margin-top: 2px;
    }

    #consigneeSections .nav {
        justify-content: left;
        background: #c7c7c6 !important;
        padding: 4px 0 7px 4px;
        margin: -8px 0 0 0;
    }



    #shipperForms .nav li a {
        color: #000 !important;
        background: unset;
        border: unset !important;
        font-size: 12px;

    }

    #shipperForms .nav li {
        border: 1px solid #ccc;
        padding: 3px 4px;
        border-radius: 10px;
        background: #fff;
        margin-right: 10px;
        margin-top: 2px;
    }

    #shipperForms .nav {
        justify-content: left;
        background: #c7c7c6 !important;
        padding: 4px 0 7px 4px;
        margin: -8px 0 0 0;
    }
    .info{
    padding: 7px !important;
    margin-left: 12px;
    margin-top: 0;
}
/* .info:hover {
    background: #1cbfd0 !important;
} */
label {
    margin-bottom: 0;
    font-weight: 600;
    text-align: left;
    font-size: 13px;
    color: #4a4a4a;
}
.form-control {
    font-weight: 500;
    height: 31px !important;
    font-size: 13px;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}
.form-group {
    margin: 10px 0 0 0;
}
.modal{
    font-family: 'Poppins';
}
.modal .card-title.head {
    font-size: 13px;
    text-align: left;
    font-weight: 700;
}
label.upload-button {
    text-align: center;
    border: 1px solid #ccc;
    height: 80px;
    border-radius: 8px;
    width: 100%;
}
.upload-button input#upload {
    position: absolute;
    right: -9999px;
    visibility: hidden;
    opacity: 0;
}
.upload-button p.choose-file {
    padding: 9px 6px;
    font-size: 12px;
    color: #728f22;
}
.form-group p {
    margin-bottom: 4px;
    font-size: 13px;
    color: #817d7d;
}
.title {
        margin-top: 30px;
        margin-bottom: 0;
        font-size: 14px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid #577604;
        background: #e9ecef;
        color: #000;
        padding: 5px 6px;
        border-radius: 6px;
     }
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important">
            <h2><b>Edit Load Details</b></h2>
        </div>

        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 p-0">
                    <div class="card">
                        <div class="body">
                            <form method="POST" action="{{ route('broker.load.update', ['id' => $post->id]) }}"
                                id="myFormLoad" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                  <h3 class="title mt-0" style="font-size:13px;background: #263544;color:#fff;padding: 9px 6px;">Load Details</h3>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Load Number <code>*</code></label>
                                                <input class="form-control" name="load_number" disabled
                                                    value="{{ $post->load_number }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Bill To <code>*</code>
                                                    <a href="{{ route('customer') }}" target="_blank" style="background: none; border: none;"><i class="fa fa-plus"></i> Add New</a>
                                                </label>
                                                <input type="text" id="load_bill_to" name="load_bill_to" class="form-control" value="{{ $post->load_bill_to }}" readonly autocomplete="off" placeholder="Customer name">
                                                <span class="error"></span>
                                                <span id="customerErrorMessage" style="color: red; display: none;">Please select the customer from the list</span>
                                                <textarea id="customerList" class="form-control" style="display: none;" readonly></textarea>
                                                <input type="hidden" id="customer_id" name="customer_id" value="{{ $post->customer_id }}">
                                                <input type="hidden" id="customer_credit_limit" name="customer_credit_limit" value="{{ $post->customer->approved_limit }}">
                                                <input type="hidden" id="old_shipper_load_final_rate" name="old_shipper_load_final_rate" value="{{ $post->shipper_load_final_rate }}">


                                                @php
                                                    $remaning = $post->customer->remaining_credit ;
                                                    $exsitingamt = $post->shipper_load_final_rate ;
                                                    $totalamt = $remaning + $exsitingamt;
                                                @endphp

                                                <input type="hidden" id="remaining_credit" name="remaining_credit" value="{{ $totalamt }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Dispatcher <code>*</code></label>
                                                <input class="form-control" name="load_dispatcher"
                                                    value="{{ $post->user->name }}" required readonly
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Load Type <code>*</code></label>
                                                <div class="select2-purple">
                                                    <select class="form-control select2" name="load_type_two" style="width: 100%;" required>
                                                        <!-- Preselected value -->
                                                        <!-- <option disabled selected value="{{ $post->load_type_two }}" style="color:#e9ecef" title="Already Selected">
                                                            {{ $post->load_type_two ? $post->load_type_two : 'Select Load Type' }}
                                                        </option> -->

                                                        <!-- Load Type Options -->
                                                        <option value="OTR" {{ $post->load_type_two == 'OTR' ? 'selected' : '' }}>OTR</option>
                                                        <option value="DRAYAGE" {{ $post->load_type_two == 'DRAYAGE' ? 'selected' : '' }}>DRAYAGE</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Customer r/f# </label>
                                                <input class="form-control" name="customer_refrence_number"
                                                    value="{{ $post->customer_refrence_number }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Work Order </label>
                                                <input class="form-control" name="load_workorder"
                                                    value="{{ $post->load_workorder }}" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Shipment Type <code>*</code></label>
                                            <select required class="form-control select2" name="load_type" style="width: 100%;">
                                                <!-- Preselected value with a disabled option -->
                                                <!-- <option hidden value="{{ $post->load_type }}"  style="color:#e9ecef" title="Already Selected">
                                                    {{ $post->load_type ? $post->load_type : 'Select Shipment Type' }}
                                                </option> -->

                                                <!-- Shipment Type Options -->
                                                <option value="FCL" {{ $post->load_type == 'FCL' ? 'selected' : '' }}>FCL</option>
                                                <option value="LCL" {{ $post->load_type == 'LCL' ? 'selected' : '' }}>LCL</option>
                                                <option value="FTL" {{ $post->load_type == 'FTL' ? 'selected' : '' }}>FTL</option>
                                                <option value="LTL" {{ $post->load_type == 'LTL' ? 'selected' : '' }}>LTL</option>
                                                <option value="Partial" {{ $post->load_type == 'Partial' ? 'selected' : '' }}>Partial</option>
                                                <option value="Transloading" {{ $post->load_type == 'Transloading' ? 'selected' : '' }}>Transloading</option>
                                                <option value="Warehousing" {{ $post->load_type == 'Warehousing' ? 'selected' : '' }}>Warehousing</option>
                                                <option value="TONU" {{ $post->load_type == 'TONU' ? 'selected' : '' }}>TONU</option>
                                            </select>
                                        </div>
                                    </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Payment Type <code>*</code></label>
                                                <select class="form-control select2" required name="load_payment_type" style="width: 100%;">
                                                    <!-- Preselected value with a disabled option -->
                                                    <!-- <option disabled selected value="{{ $post->load_payment_type }}" style="color:#e9ecef" title="Already Selected">
                                                        {{ $post->load_payment_type ? $post->load_payment_type : 'Select Payment Type' }}
                                                    </option> -->
                                                    
                                                    <!-- Option for Prepaid -->
                                                    <option value="Prepaid" {{ $post->load_payment_type == 'Prepaid' ? 'selected' : '' }}>Prepaid</option>
                                                    
                                                    <!-- Option for Postpaid -->
                                                    <option value="Postpaid" {{ $post->load_payment_type == 'Postpaid' ? 'selected' : '' }}>Postpaid</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select class="form-control select2" name="load_currency" style="width: 100%;">
                                                    <!-- Preselected value with a disabled option -->
                                                    <!-- <option disabled selected value="{{ $post->load_currency }}" style="color:#e9ecef" title="Already Selected">
                                                        {{ $post->load_currency }}
                                                    </option> -->
                                                    <option value="$" {{ $post->load_currency == '$' ? 'selected' : '' }}>$</option>
                                                    <option value="CAD" {{ $post->load_currency == 'CAD' ? 'selected' : '' }}>CAD</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Equipment Type <code>*</code></label>
                                                <select class="form-control select2" name="load_equipment_type" id="load_equipment_type" style="width: 100%;" required>
                                                    <option value="Container Trailer" {{ $post->load_equipment_type == 'Container Trailer' ? 'selected' : '' }}>Container Trailer</option>
                                                    <option value="22' VAN" {{ $post->load_equipment_type == "22' VAN" ? 'selected' : '' }}>22' VAN</option>
                                                    <option value="48' Reefer" {{ $post->load_equipment_type == "48' Reefer" ? 'selected' : '' }}>48' Reefer</option>
                                                    <option value="53' Reefer" {{ $post->load_equipment_type == "53' Reefer" ? 'selected' : '' }}>53' Reefer</option>
                                                    <option value="53' VAN" {{ $post->load_equipment_type == "53' VAN" ? 'selected' : '' }}>53' VAN</option>
                                                    <option value="Air Freight" {{ $post->load_equipment_type == 'Air Freight' ? 'selected' : '' }}>Air Freight</option>
                                                    <option value="Anhydros Ammonia" {{ $post->load_equipment_type == 'Anhydros Ammonia' ? 'selected' : '' }}>Anhydros Ammonia</option>
                                                    <option value="Animal Carrier" {{ $post->load_equipment_type == 'Animal Carrier' ? 'selected' : '' }}>Animal Carrier</option>
                                                    <option value="Any Equipment" {{ $post->load_equipment_type == 'Any Equipment' ? 'selected' : '' }}>Any Equipment</option>
                                                    <option value="Searching Services only" {{ $post->load_equipment_type == 'Searching Services only' ? 'selected' : '' }}>Any Equipment (Searching Services only)</option>
                                                    <option value="Van - Air-Ride" {{ $post->load_equipment_type == "Van - Air-Ride" ? 'selected' : '' }}>Van - Air-Ride</option>
                                                    <option value="Van Intermodal" {{ $post->load_equipment_type == "Van Intermodal" ? 'selected' : '' }}>Van Intermodal</option>
                                                    <option value="Van or Flatbed" {{ $post->load_equipment_type == "Van or Flatbed" ? 'selected' : '' }}>Van or Flatbed</option>
                                                    <option value="Van or Reefer" {{ $post->load_equipment_type == "Van or Reefer" ? 'selected' : '' }}>Van or Reefer</option>
                                                    <option value="Van Pallet Exchange" {{ $post->load_equipment_type == "Van Pallet Exchange" ? 'selected' : '' }}>Van Pallet Exchange</option>
                                                    <option value="Van with Liftgate" {{ $post->load_equipment_type == "Van with Liftgate" ? 'selected' : '' }}>Van with Liftgate</option>
                                                    <option value="Van, Reefer or Double Drop" {{ $post->load_equipment_type == "Van, Reefer or Double Drop" ? 'selected' : '' }}>Van, Reefer or Double Drop</option>
                                                    <option value="Vented Insulated Van" {{ $post->load_equipment_type == "Vented Insulated Van" ? 'selected' : '' }}>Vented Insulated Van</option>
                                                    <option value="Vented Insulated Van or Refrigerated" {{ $post->load_equipment_type == "Vented Insulated Van or Refrigerated" ? 'selected' : '' }}>Vented Insulated Van or Refrigerated</option>
                                                    <option value="Vented Van" {{ $post->load_equipment_type == "Vented Van" ? 'selected' : '' }}>Vented Van</option>
                                                    <option value="Vented Van or Refrigerated" {{ $post->load_equipment_type == "Vented Van or Refrigerated" ? 'selected' : '' }}>Vented Van or Refrigerated</option>
                                                    <option value="Walking Floor" {{ $post->load_equipment_type == "Walking Floor" ? 'selected' : '' }}>Walking Floor</option>
                                                    <option value="BOX Truck" {{ $post->load_equipment_type == "BOX Truck" ? 'selected' : '' }}>BOX Truck</option>
                                                    <option value="Reefer Container" {{ $post->load_equipment_type == "Reefer Container" ? 'selected' : '' }}>Reefer Container</option>
                                                    <option value="Tandem" {{ $post->load_equipment_type == "Tandem" ? 'selected' : '' }}>Tandem</option>
                                                    <option value="B Train" {{ $post->load_equipment_type == "B Train" ? 'selected' : '' }}>B Train</option>
                                                    <option value="Flatbed with Tarps" {{ $post->load_equipment_type == "Flatbed with Tarps" ? 'selected' : '' }}>Flatbed with Tarps</option>
                                                    <option value="Flatbed with straps" {{ $post->load_equipment_type == "Flatbed with straps" ? 'selected' : '' }}>Flatbed with straps</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control select2" name="load_status" style="width: 100%;">
                                                    <option value="Open" {{ $post->load_status == 'Open' ? 'selected' : '' }}>Open</option>
                                                    <option value="Covered" {{ $post->load_status == 'Covered' ? 'selected' : '' }}>Covered</option>
                                                    <option value="Dispatched" {{ $post->load_status == 'Dispatched' ? 'selected' : '' }}>Dispatched</option>
                                                    <option value="Loading" {{ $post->load_status == 'Loading' ? 'selected' : '' }}>Loading</option>
                                                    <option value="On Route" {{ $post->load_status == 'On Route' ? 'selected' : '' }}>On Route</option>
                                                    <option value="Un loading" {{ $post->load_status == 'Un loading' ? 'selected' : '' }}>Un loading</option>
                                                    <option value="Delivered" {{ $post->load_status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="title" style="font-size:13px;">Customer
                                        <a href="{{ route('shipper.rc.pdf', ['id' => $post->id]) }}" target="_blank">
                                            <i class="fas fa-file-pdf dynamic-data"
                                                style="margin:0 10px;color:red; font-size: 20px;"></i>
                                        </a>
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Customer Rate <code>*</code></label>
                                                <!-- <input type="text" class="form-control number value"
                                                    name="load_shipper_rate" id="load_shipper_rate" required
                                                    value="{{ $post->load_shipper_rate }}" style="width: 100%;"> -->
                                                    <input type="text" class="form-control number value" id="load_shipper_rate" name="load_shipper_rate" required value="{{ $post->load_shipper_rate }}">
                                                    <span id="error_load_shipper_rate" style="color: red; display: none;">Only numbers and decimals allowed</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>F.S.C Rate % <input hidden type="checkbox"
                                                        name="calculate_fsc_percentage"
                                                        id="calculate_fsc_percentage"></label>
                                                <input type="number" class="form-control number percent"
                                                    name="load_fsc_rate" id="load_fsc_rate"
                                                    value="{{ $post->load_fsc_rate }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="other_charge">Customer Other Charges &nbsp; <i
                                                        class="fa fa-plus" data-toggle="modal" data-target="#myModal"
                                                        id="load_shipper_other_charges"></i></label>
                                                <input class="form-control" style="width: 100%;"
                                                    name="shipper_total_other_charge" id="shipper_total_other_charge">
                                            </div>
                                            <div class="modal close_shipper_other_charges_form" id="myModal">
                                                <div class="modal-dialog" style="max-width: 840px;">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="font-size: 17px;text-align: left;margin-left: 9px;font-weight: 700;">Customer Other Charges</h4>
                                                            <button type="button" class="close" data-dismiss="modal" style="font-size: 23px;top: 30px;">&times;</button>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <div class="modal-body">
                                                            <div class="container">
                                                                @php
                                                                $shipperCharges =
                                                                json_decode($post->shipper_load_other_charge, true);
                                                                if (json_last_error() !== JSON_ERROR_NONE ||
                                                                !is_array($shipperCharges)) {
                                                                // Handle JSON error or invalid data
                                                                $shipperCharges = [];
                                                                }

                                                                $carrierCharges =
                                                                json_decode($post->carrier_load_other_charge, true);
                                                                if (json_last_error() !== JSON_ERROR_NONE ||
                                                                !is_array($carrierCharges)) {
                                                                // Handle JSON error or invalid data
                                                                $carrierCharges = [];
                                                                }
                                                                @endphp
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="shipperchargeType">Charge Type:</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label>Amount:</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @foreach($shipperCharges as $index => $shipperCharge)
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control"
                                                                                    name="shipperchargeType[]"
                                                                                    value="{{ htmlspecialchars($shipperCharge['type'] ?? '') }}"
                                                                                    placeholder="Enter Charge Type">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="form-group">
                                                                                <input type="text" step="0.01"
                                                                                    class="form-control"
                                                                                    name="shipperchargeAmount[]"
                                                                                    value="{{ number_format((float)($shipperCharge['amount'] ?? 0), 2) }}"
                                                                                    placeholder="Enter Amount">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1" style="margin-top: 21px;">
                                                                            <button class="remove-row"
                                                                                style="background:unset;border:none; color:red;"
                                                                                type="button"><i class="fa fa-trash"></i></button>
                                                                        </div>
                                                                    </div>
                                                                @endforeach




                                                                <!-- Add a button to dynamically add more rows if needed -->
                                                                <div id="dynamic-field-container">
                                                                    <!-- Rows will be dynamically added here -->
                                                                </div>
                                                                <!-- <button type="button" id="add-row" class="btn btn-primary">Add Charge</button> -->


                                                                <!-- Hidden template row -->
                                                                <div class="row" id="chargeRowTemplate"
                                                                    style="display: none;">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                name="shipperchargeType[]"
                                                                                placeholder="Enter Charge Type">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                name="shipperchargeAmount[]"
                                                                                placeholder="Enter Amount">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1" style="margin-top: 11px;">
                                                                        <button class="remove-row" type="button"
                                                                            style="background:unset;border:none"><i
                                                                                style="margin-top: 15px; color:red;"
                                                                                class="fa fa-trash"></i></button>
                                                                    </div>
                                                                </div>

                                                                <!-- Container for new rows -->
                                                                <div id="chargeRowsContainer"></div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer mt-4">
                                                            <button type="button" class="btn btn-success"
                                                                id="addChargeBtn">Add New Charges</button>
                                                        </div>
                                                        <!-- Modal Footer -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Customer Final Rate<code>*</code></label>
                                                <!-- <input type="number" id="shipper_load_final_rate" name="shipper_load_final_rate" class="form-control" required> -->
                                                <input type="text" class="form-control" id="shipper_load_final_rate"
                                                    name="shipper_load_final_rate" style="pointer-events: none;background-color: #e9ecef; color: #6c757d;"
                                                    value="{{ $post->shipper_load_final_rate }}" required />

                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="title" style="font-size:13px;background: #263544;color:#fff;">Carrier
                                        <a href="{{ route('download.pdf', ['id' => $post->id]) }}" target="_blank">
                                            <i class="fas fa-file-pdf dynamic-data"
                                                style="margin:0 10px; font-size: 20px; color:red;"></i>
                                        </a>
                                    </h3>
                                    @php
                                        $isReadonly = $post->cpr_check == 'Verified';
                                    @endphp

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier <code>*</code></label>
                                                <input type="text" id="load_carrier" name="load_carrier" value="{{ $post->load_carrier }}" 
                                                    class="form-control" style="width: 100%;" autocomplete="off" 
                                                    {{ $isReadonly ? 'readonly' : '' }}>
                                                <input type="text" hidden name="carrier_id" id="carrier_id" value="{{ $post->carrier_id }}">
                                                <ul id="carrier-list" class="list-group" style="position: absolute; z-index: 1000; width: 100%; display: none;"></ul>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>MC No <code>*</code></label>
                                                <input class="form-control" required name="load_mc_no" id="carrier_mc_ff_input" 
                                                    style="width: 100%;" placeholder="Enter MC Number" 
                                                    value="{{ $post->load_mc_no }}" {{ $isReadonly ? 'readonly' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>DOT No</label>
                                                <input class="form-control" name="carrier_dot" id="carrier_dot" style="width: 100%;" 
                                                    placeholder="Enter DOT Number" value="{{ $post->carrier_dot }}" 
                                                    {{ $isReadonly ? 'readonly' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier Phone<code>*</code></label>
                                                <input type="text" id="load_carrier_phone" name="load_carrier_phone" 
                                                    value="{{ $post->load_carrier_phone }}" class="form-control" style="width: 100%;" 
                                                    {{ $isReadonly ? 'readonly' : '' }}>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Billing Type</label>
                                                <select class="form-control select2" name="load_billing_type"
                                                    style="width: 100%;">
                                                    <option selected="selected" value="{{ $post->load_billing_type }}">
                                                        {{ $post->load_billing_type }}</option>
                                                    <option>Factoring</option>
                                                    <option>Direct Billing</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Carrier Rate <code>*</code></label>
                                                <!-- <input class="form-control" type="text" name="load_carrier_fee"
                                                    id="load_carrier_fee" value="{{ $post->load_carrier_fee }}" required
                                                    style="width: 100%;"> -->
                                                    <input type="text" class="form-control" name="load_carrier_fee" id="load_carrier_fee" value="{{ $post->load_carrier_fee }}" required>
                                                    <span id="error_load_carrier_fee" style="color: red; display: none;">Only numbers and decimals allowed</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>FSC Rate %</label>
                                                <input type="text" name="load_billing_fsc_rate"
                                                    id="load_billing_fsc_rate" class="form-control"
                                                    value="{{ $post->load_billing_fsc_rate }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        @php
                                        $carrierCharges = json_decode($post->carrier_load_other_charge, true);
                                        @endphp
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="other_charge">Carrier Other Charges <i class="fa fa-plus"
                                                data-toggle="modal" data-target="#otherChargesModal"></i></label>
                                                <input type="text" class="form-control" style="width: 100%;"
                                                    name="carrier_total_other_charge" id="carrier_total_other_charge"
                                                    readonly>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal" id="otherChargesModal">
                                                <div class="modal-dialog" style="max-width: 840px;">
                                                    <div class="modal-content" id="model_content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel" style="font-size: 17px;text-align: left;margin-left: 9px;font-weight: 700;">Carrier Other Charges</h5>
                                                            <button type="button" class="close" data-dismiss="modal" style="font-size: 23px;top: 30px;">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container">
                                                                @php
                                                                // Decode the JSON data and check for errors
                                                                $carrierCharges =
                                                                json_decode($post->carrier_load_other_charge, true);
                                                                if (json_last_error() !== JSON_ERROR_NONE ||
                                                                !is_array($carrierCharges)) {
                                                                // Handle JSON error or invalid data
                                                                $carrierCharges = [];
                                                                }
                                                                @endphp
                                                                <div class="row charge-row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mt-3">
                                                                            <label>Charge Type:</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group mt-3">
                                                                            <label>Amount:</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Fetched fields with values from the database -->
                                                                @foreach($carrierCharges as $index => $carrierCharge)
                                                                    <div class="row charge-row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group mt-3">
                                                                                <input type="text"
                                                                                    class="form-control typeofcharge"
                                                                                    placeholder="Enter Charges Type"
                                                                                    name="shipper_type_charge[]"
                                                                                    value="{{ htmlspecialchars($carrierCharge['type'] ?? '') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="form-group mt-3">
                                                                                <input type="text" step="0.01"
                                                                                    class="form-control otheramount"
                                                                                    placeholder="Enter Amount"
                                                                                    name="shipper_other_charge[]"
                                                                                    value="{{ number_format((float)($carrierCharge['amount'] ?? 0), 2) }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1" style="margin-top: 8px;">
                                                                            <button type="button"
                                                                                style="background:unset;border:none"
                                                                                class="remove-charge">
                                                                                <i class="fa fa-trash"
                                                                                    style="margin-top: 15px; color:red;"
                                                                                    aria-hidden="true"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                @endforeach


                                                                <!-- Container for dynamically added fields -->
                                                                <div id="inputs"></div>
                                                            </div>

                                                            <div class="modal-footer mt-3">
                                                                <button type="button"
                                                                    class="btn btn-success create-input">Add New Charges</button>
                                                            </div>
                                                        </div>

                                                        <!-- Hidden template row for cloning -->
                                                        <div id="chargeRowTemplatecarrier" style="display:none;">
                                                            <div class="row charge-row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text"
                                                                            class="form-control typeofcharge"
                                                                            placeholder="Enter Charges Type"
                                                                            name="shipper_type_charge[]">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <input type="text"
                                                                            class="form-control otheramount"
                                                                            placeholder="Enter Amount"
                                                                            name="shipper_other_charge[]">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1" style="margin-top: 21px;">
                                                                    <button class="closebtn"
                                                                        style="border: none; background: unset; color:red;">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Carrier Final Rate</label>
                                                <input class="form-control" readonly name="load_final_carrier_fee"
                                                    value="{{ $post->load_final_carrier_fee }}"
                                                    id="load_final_carrier_fee" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Advance Payment</label>
                                                <input class="form-control" name="load_advance_payment"
                                                    value="{{ $post->load_advance_payment }}" style="width: 100%;"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                    // Shipper Data Initialization
                                    $shipperData = json_decode($post->load_shipperr, true) ?? [];
                                    $shipperQty = json_decode($post->load_shipper_qty, true) ?? [];
                                    $shipperWeight = json_decode($post->load_shipper_weight, true) ?? [];
                                    $shipperDescription = json_decode($post->load_shipper_discription, true) ?? [];
                                    $shipperType = json_decode($post->load_shipper_commodity_type, true) ?? [];
                                    $shipperNotes = json_decode($post->load_shipper_shipping_notes, true) ?? [];
                                    $shipperContact = json_decode($post->load_shipper_contact, true) ?? [];
                                    $shipperLocation = json_decode($post->load_shipper_location, true) ?? [];
                                    $shipperAppointment = json_decode($post->load_shipper_appointment, true) ?? [];
                                    $shipperCommodity = json_decode($post->load_shipper_commodity, true) ?? [];
                                    $shipperValue = json_decode($post->load_shipper_value, true) ?? [];
                                    $shipperPoNumber = json_decode($post->load_shipper_po_numbers, true) ?? [];
                                    $allShippers = app(\App\Models\Shipper::class)->where('user_id',
                                    auth()->id())->get();
                                    $shipperCounter = count($shipperData) + 1; // Adjust counter based on existing data
                                    @endphp

                                    <div class="table-responsive">
                                        <div class="d-flex" style="padding: 29px 0 0 0;">
                                            <button id="btnAddShipper" type="button" class="btn btn-primary" style="padding: 4px 6px; font-size: 12px;margin-right: 10px;">
                                                <i class="fa fa-plus" style="font-size: 10px;"></i> Add Shipper
                                            </button>
                                           <a href="{{ route('shipper') }}" target="blank" style="padding: 9px 0"><i class="fa fa-plus mr-2"></i>Add New </a>
                                           </div>
                                       
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="shipperTable">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 12px;">#</th>
                                                        <th style="font-size: 12px;">Shipper<code>*</code></th>
                                                        <th style="font-size: 12px;">Shipper Location</th>
                                                        <th style="font-size: 12px;">Appointment</th>
                                                        <th style="font-size: 12px;">Commodity Type</th>
                                                        <th style="font-size: 12px;">Commodity Name<code>*</code></th>
                                                        <th style="font-size: 12px;">Qty</th>
                                                        <th style="font-size: 12px;">Weight (lbs)</th>
                                                        <th style="font-size: 12px;">Value($)<code>*</code></th>
                                                        <th style="font-size: 12px;">PO Numbers</th>
                                                        <th style="font-size: 12px;">Contact</th>
                                                        <th style="font-size: 12px;">Description</th>
                                                        <th style="font-size: 12px;">Shipper Notes</th>
                                                        <th style="font-size: 12px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($shipperData as $key => $shipper)
                                                    <tr id="shipperRow{{ $key + 1 }}">
                                                        <td style="padding: 7px;">S {{ $key + 1 }}</td>
                                                        <td style="padding: 7px;">
                                                            <select class="form-control load_shipper shipper-select" style="width:200px;" name="load_shipper_{{ $key + 1 }}" id="load_shipper_{{ $key + 1 }}" required>
                                                                <option value="{{ $shipper['name'] }}" hidden>{{ $shipper['name'] }}</option>
                                                                <option value="">Select Shipper</option>
                                                                @foreach($allShippers as $get)
                                                                <option value="{{ $get->shipper_name }}" data-id="{{ $get->id }}">{{ $get->shipper_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 480px;" value="{{ $shipperLocation[$key]['location'] ?? '' }}" title="{{ $shipperLocation[$key]['location'] ?? '' }}" 
                                                            name="load_shipper_location_{{ $key + 1 }}" id="load_shipper_location_{{ $key + 1 }}" readonly>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" type="datetime-local" name="load_shipper_appointment_{{ $key + 1 }}" value="{{ $shipperAppointment[$key]['appointment'] ?? '' }}">
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 160px;" name="load_shipper_type_{{ $key + 1 }}" value="{{ isset($shipperType[$key]['commodity_type']) ? $shipperType[$key]['commodity_type'] : ($shipperType[$key]['type'] ?? '') }}">
                                                        </td>

                                                        <td style="padding: 7px;">
                                                            <input class="form-control" name="load_shipper_commodity_{{ $key + 1 }}" value="{{ isset($shipperCommodity[$key]['commodity_name']) ? $shipperCommodity[$key]['commodity_name'] : ($shipperCommodity[$key]['commodity'] ?? '') }}"  required>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 87px;" type="number" name="load_shipper_qty_{{ $key + 1 }}" value="{{ isset($shipperQty[$key]['shipper_qty']) ? $shipperQty[$key]['shipper_qty'] : ($shipperQty[$key]['qty'] ?? '0') }}" >
                                                        </td>
                                                        <td style="padding: 7px;">
                                                        <input class="form-control" style="width: 90px;" type="number" name="load_shipper_weight_{{ $key + 1 }}" value="{{ isset($shipperWeight[$key]['shipper_weight']) ? $shipperWeight[$key]['shipper_weight'] : ($shipperWeight[$key]['weight'] ?? '0') }}">

                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 90px;" required type="number" name="load_shipper_value_{{ $key + 1 }}" value="{{ isset($shipperValue[$key]['shipper_value']) ? $shipperValue[$key]['shipper_value'] : ($shipperValue[$key]['value'] ?? '0') }}">
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 130px;" name="load_shipper_po_numbers_{{ $key + 1 }}" value="{{ isset($shipperPoNumber[$key]['shipping_po_numbers']) ? $shipperPoNumber[$key]['shipping_po_numbers'] : $shipperPoNumber[$key]['po_number'] ?? '0' }}">
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 131px;" type="number" name="load_shipper_contact_{{ $key + 1 }}" value="{{ $shipperContact[$key]['shipping_contact'] ?? $shipperContact[$key]['contact'] ?? '0' }}">
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 210px;" name="load_shipper_description_{{ $key + 1 }}" value="{{ $shipperDescription[$key]['description'] ?? 'NA' }}">
                                                        </td>
                                                        <td style="padding: 7px;">
                                                        <textarea style="width: auto; font-size: 12px; border: 1px solid #ced4da; border-radius: .25rem;" name="load_shipper_notes_{{ $key + 1 }}">
                                                                {{ isset($shipperNotes[$key]['shipping_notes']) ? $shipperNotes[$key]['shipping_notes'] : $shipperNotes[$key]['notes'] ?? 'NA' }}
                                                        </textarea>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <a href="javascript:void(0);" class="btn-remove-shipper" data-row="shipperRow{{ $key + 1 }}">
                                                                <i class="fa fa-trash" style="color:red"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                    </div>

                                    @php
                                        $counter = 1; // Start counter from 1
                                        $consigneeData = json_decode($post->load_consignee, true) ?? [];
                                        $consigneeQty = json_decode($post->load_consignee_qty, true) ?? [];
                                        $consigneeWeight = json_decode($post->load_consignee_weight, true) ?? [];
                                        $consigneeDescription = json_decode($post->load_consignee_discription, true) ?? [];
                                        $consigneeType = json_decode($post->load_consignee_type, true) ?? [];
                                        $consigneeNotes = json_decode($post->load_consigneer_notes, true) ?? [];
                                        $consigneeLocation = json_decode($post->load_consignee_location, true) ?? [];
                                        $consigneeAppointment = json_decode($post->load_consignee_appointment, true) ?? [];
                                        $consigneeCommodity = json_decode($post->load_consignee_commodity, true) ?? [];
                                        $consigneeValue = json_decode($post->load_consignee_value, true) ?? [];
                                        $consigneePoNumber = json_decode($post->load_consignee_po_numbers, true) ?? [];
                                        $consigneeContact = json_decode($post->load_consigneer_contact, true) ?? [];
                                        $allConsignees = \App\Models\Consignee::where('user_id', auth()->id())->get();
                                        $consigneeCounter = count($consigneeData);
                                    @endphp

                                    <div class="table-responsive">
                                        <div class="d-flex" style="padding: 29px 0 0 0;">
                                            <button id="btnAddConsignee" type="button" class="btn btn-primary mt-2" style="padding: 4px 6px; font-size: 12px; margin-right: 10px;">
                                                <i class="fa fa-plus mr-2" style="font-size: 10px;"></i> Add Consignee
                                            </button>
                                            <a href="{{ route('consignee') }}" target="blank" style="padding: 9px 0"><i class="fa fa-plus mr-2"></i>Add New</a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="consigneeTable">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 12px;">#</th>
                                                        <th style="font-size: 12px;">Consignee <code>*</code></th>
                                                        <th style="font-size: 12px;">Consignee Location</th>
                                                        <th style="font-size: 12px;">Appointment</th>
                                                        <th style="font-size: 12px;">Commodity Type</th>
                                                        <th style="font-size: 12px;">Commodity Name <code>*</code></th>
                                                        <th style="font-size: 12px;">Qty</th>
                                                        <th style="font-size: 12px;">Weight (lbs)</th>
                                                        <th style="font-size: 12px;">Value ($) <code>*</code></th>
                                                        <th style="font-size: 12px;">PO Number</th>
                                                        <th style="font-size: 12px;">Contact</th>
                                                        <th style="font-size: 12px;">Description</th>
                                                        <th style="font-size: 12px;">Consignee Notes</th>
                                                        <th style="font-size: 12px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($consigneeData as $key => $consignee)
                                                    <tr id="consigneeRow{{ $key + 1 }}">
                                                        <td>C {{ $key + 1 }}</td>
                                                        <td>
                                                            <select class="form-control load_consignee consignee-select" name="load_consignee_{{ $key + 1 }}" id="load_consignee_{{ $key + 1 }}" data-row="{{ $key + 1 }}" required style="width: 200px;">
                                                                <option value="{{ $consignee['name'] }}" hidden>{{ $consignee['name'] }}</option>
                                                                <option value="">Select Consignee</option>
                                                                @foreach($allConsignees as $get)
                                                                <option value="{{ $get->consignee_name }}" data-id="{{ $get->id }}">{{ $get->consignee_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" style="width: 480px;" name="load_consignee_location_{{ $key + 1 }}" id="load_consignee_location_{{ $key + 1 }}" value="{{ $consigneeLocation[$key]['location'] ?? '' }}" readonly title="{{ $consigneeLocation[$key]['location'] ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="datetime-local" name="load_consignee_appointment_{{ $key + 1 }}" value="{{ $consigneeAppointment[$key]['appointment'] ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" style="width: 160px;" name="load_consignee_type_{{ $key + 1 }}" value="{{ $consigneeType[$key]['consignee_type'] ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="load_consignee_commodity_{{ $key + 1 }}" value="{{ $consigneeCommodity[$key]['consignee_commodity'] ?? '' }}" required>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" style="width: 87px;" type="text" name="load_consignee_qty_{{ $key + 1 }}" value="{{ $consigneeQty[$key]['consignee_qty'] ?? '0' }}">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" style="width: 90px;" name="load_consignee_weight_{{ $key + 1 }}" type="text" value="{{ $consigneeWeight[$key]['consignee_weight'] ?? '0' }}">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" style="width: 90px;" required name="load_consignee_value_{{ $key + 1 }}" type="text" value="{{ $consigneeValue[$key]['consignee_value'] ?? '0' }}">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" style="width: 130px;" name="load_consignee_po_numbers_{{ $key + 1 }}" value="{{ $consigneePoNumber[$key]['consignee_po_number'] ?? '0' }}">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" style="width: 131px;" name="load_consigneer_contact_{{ $key + 1 }}" type="number" value="{{ $consigneeContact[$key]['consignee_contact'] ?? '0' }}">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" style="width: 210px;" name="load_consignee_discription_{{ $key + 1 }}" value="{{ $consigneeDescription[$key]['description'] ?? 'NA' }}">
                                                        </td>
                                                        <td>
                                                            <textarea style="width: auto; font-size: 12px; border: 1px solid #ced4da; border-radius: .25rem;" name="load_consignee_notes_{{ $key + 1 }}">{{ isset($consigneeNotes[$key]['load_consignee_notes']) ? htmlspecialchars(trim($consigneeNotes[$key]['load_consignee_notes']), ENT_QUOTES, 'UTF-8') : 'NA' }}</textarea>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0);" class="btn-remove-consignee" data-row="consigneeRow{{ $key + 1 }}"><i style="color:red;" class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <input type="hidden" id="consignee_count" name="consignee_count" value="{{ $consigneeCounter }}">


                                    <div class="modal-footer">
                                        <a class="upload"
                                            style=" background-color: #0c7ce6;color: #fff;padding: 5px 11px;border-radius: 6px;"
                                            href="{{ route('files.upload', ['filesId' => $post->id]) }}"
                                            target="blank"><i class="fa fa-upload dynamic-data" aria-hidden="true"
                                                style="margin:0 10px; font-size: 20px;"></i>Upload</a>
                                            <button type="button" data-toggle="modal" data-target="#billOfLadingModal" class="btn btn-warning"><i class="fas fa-file-pdf mr-2"></i>Bill of Lading</button>
                                        <input type="submit" class="btn btn-info" value="Save" onclick="saveFormData()">
                                        <a href="https://crmcargoconvoy.co/load" class="btn btn-danger"
                                            data-dismiss="modal">Cancel</a>
                                    </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade p-0" id="billOfLadingModal" tabindex="-1" role="dialog" aria-labelledby="billOfLadingLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="billOfLadingLabel">Bill of Lading</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="color:#fff;" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div class="table-responsive">
                        <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>BoL Number</th>
                                        <th>Carrier Name</th>
                                        <th>Freight Charges</th>
                                        <th>Pickup Locations</th>
                                        <th>Drop Locations</th>
                                        <th>Bill of Lading Qty</th>
                                        <th>Bill of Lading Weight</th>
                                        <th>Items</th>
                                        <th>Files / Print</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    <tr>
                                        <td><input type="text" name="bol_name" value="{{ $i++ }}" id="bol_name" class="form-control"></td>
                                        @php
                                            $allexternalcarrier = \App\Models\External::where('user_id', auth()->id())->get();
                                        @endphp

                                        <td>
                                            <select name="carrier" id="carrier" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($allexternalcarrier as $carrier)
                                                    <option value="{{ $carrier->carrier_name }}">{{ $carrier->carrier_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select name="freight_charges" id="freight_charges" class="form-control">
                                                <option value="">Select</option>
                                                <option value="Collect">Collect</option>
                                                <option value="Prepaid">Prepaid</option>
                                            </select>
                                        </td>
                                        @php
                                            $allShipper = \App\Models\Shipper::where('user_id', auth()->id())->get();
                                        @endphp

                                        <td>
                                            <select name="origin" id="origin" class="form-control">
                                                <option value="">Select</option>
                                                <!-- Loop through the shippers and display them as options -->
                                                @foreach($allShipper as $shipper)
                                                    <option value="{{ $shipper->shipper_name }}">{{ $shipper->shipper_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        @php
                                            $allConsignee = \App\Models\Consignee::where('user_id', auth()->id())->get();
                                        @endphp

                                        <td>
                                            <select name="destination" id="destination" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($allConsignee as $consignee)
                                                    <option value="{{ $consignee->consignee_name }}">{{ $consignee->consignee_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="bol_qty" id="bol_qty" placeholder="Enter Qty">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="bol_weight" id="bol_weight" placeholder="Enter Weight">
                                        </td>
                                        <td><button button="button" class="btn btn-primary" data-toggle="modal" data-target="#bol-items">Items</button></td>
                                        <td>
                                            <!-- File Upload -->
                                            <input type="file" name="attachment" id="attachment" class="form-control-file" style="display:none;">
                                            <label for="attachment" style="cursor:pointer;">
                                                <i class="fa fa-paperclip" aria-hidden="true" style="font-size:20px"></i>
                                            </label>

                                            <!-- Print File -->
                                            <a href="javascript:void(0);" name="print_file" id="print_file" onclick="printFile()">
                                                <i class="fa fa-print" style="font-size:20px" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade p-0" id="bol-items">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">BOL Items</h5>
            <button type="button" class="close" data-dismiss="modal" style="color:red;top: 30px;">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle;font-size: 12px;">Pieces</th>
                            <th style="vertical-align: middle;font-size: 12px;">Description</th>
                            <th style="vertical-align: middle;font-size: 12px;">Lbs</th>
                            <th style="vertical-align: middle;font-size: 12px;">Type</th>
                            <th style="vertical-align: middle;font-size: 12px;">NMFC</th>
                            <th style="vertical-align: middle;font-size: 12px;">HM</th>
                            <th style="vertical-align: middle;font-size: 12px;">Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td style="padding: 7px;">Lorem ipsum</td>
                        <td style="padding: 7px;">Lorem ipsum</td>
                        <td style="padding: 7px;">Lorem ipsum</td>
                        <td style="padding: 7px;">Lorem ipsum</td>
                        <td style="padding: 7px;">Lorem ipsum</td>
                        <td style="padding: 7px;">
                        <select class="form-control">
                            <option>Yes</option>
                            <option>No</option>
                        </select>
                        </td>
                        <td style="padding: 7px;">Lorem ipsum</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            
        </div>
        </div>
  </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize shipper counter based on existing data
        let shipperCounter = $('#shipperTable tbody tr').length;

        // Function to update serial numbers in the table
        function updateSrNo() {
            $('#shipperTable tbody tr').each(function(index) {
                $(this).find('td:first').text(`S ${index + 1}`); // Update Sr. No based on current index
            });
        }

        // Add new shipper row
        $('#btnAddShipper').click(function () {
            shipperCounter++; // Increment shipper counter
            const newRow = `
                <tr id="shipperRow${shipperCounter}">
                    <td style="padding: 7px;">S ${shipperCounter}</td>
                    <td style="padding: 7px;">
                        <select class="form-control load_shipper shipper-select" style="width:200px;" name="load_shipper_${shipperCounter}" id="load_shipper_${shipperCounter}" required>
                            <option value="">Select Shipper</option>
                            @foreach($allShippers as $get)
                            <option value="{{ $get->shipper_name }}" data-id="{{ $get->id }}">{{ $get->shipper_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" style="width: 480px;" name="load_shipper_location_${shipperCounter}" id="load_shipper_location_${shipperCounter}" readonly>
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" type="datetime-local" name="load_shipper_appointment_${shipperCounter}">
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" name="load_shipper_type_${shipperCounter}">
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" name="load_shipper_commodity_${shipperCounter}" required>
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" style="width: 87px;" type="number" name="load_shipper_qty_${shipperCounter}">
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" style="width: 90px;" type="number" name="load_shipper_weight_${shipperCounter}">
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" style="width: 90px;" required type="number" name="load_shipper_value_${shipperCounter}">
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" style="width: 130px;" name="load_shipper_po_numbers_${shipperCounter}">
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" style="width: 131px;" type="number" name="load_shipper_contact_${shipperCounter}">
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" style="width: 210px;" name="load_shipper_description_${shipperCounter}">
                    </td>
                    <td style="padding: 7px;">
                        <textarea style="width: auto;font-size: 12px;border: 1px solid #ced4da; border-radius: .25rem;" name="load_shipper_notes_${shipperCounter}"></textarea>
                    </td>
                    <td style="padding: 7px;">
                        <a type="button" class="btn-remove-shipper" data-row="shipperRow${shipperCounter}">
                            <i class="fa fa-trash" style="color:red"></i>
                        </a>
                    </td>
                </tr>
            `;
            $('#shipperTable tbody').append(newRow); // Append new row to the table
        });

        // Remove shipper row
        $(document).on('click', '.btn-remove-shipper', function () {
            const rowId = $(this).data('row');
            $('#' + rowId).remove(); // Remove the specified row
            shipperCounter--; // Decrement counter
            updateSrNo(); // Update serial numbers
        });

        // Fetch shipper details based on selection
        $(document).on('change', '.load_shipper', function () {
        const shipperId = $(this).find(':selected').data('id');
        const rowId = $(this).attr('id').replace('load_shipper_', ''); // Extract row id

        if (shipperId) {
            $.ajax({
                url: "{{ route('fetch.shipper.details.edit') }}",
                method: "GET",
                data: { id: shipperId },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        // Remove numeric words from the shipper_country
                        const cleanedCountry = data.shipper_country.replace(/\d+/g, '').trim();

                        // Populate location field with fetched shipper details
                        $('#load_shipper_location_' + rowId).val(`${data.shipper_address}, ${data.shipper_city}, ${data.shipper_state}, ${data.shipper_zip}, ${cleanedCountry}`);
                    } else {
                        console.error('No data found for this Shipper.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error); // Log any errors
                }
            });
        }
    });
    });
</script>

<script>
    $(document).ready(function () {
        let consigneeCounter = {{ $consigneeCounter }}; // Start from the existing count

        // Function to update Sr. No
        function updateSrNo() {
            $('#consigneeTable tbody tr').each(function(index) {
                $(this).find('td:first').text(`C ${index + 1}`); // Update Sr. No based on current index
            });
        }

        // Add Consignee Row
        $('#btnAddConsignee').on('click', function () {
            consigneeCounter++; // Increment counter for new row

            let newRow = `
            <tr id="consigneeRow${consigneeCounter}">
                <td style="padding: 7px;">C ${consigneeCounter}</td>
                <td style="padding: 7px;">
                    <select class="form-control load_consignee consignee-select" name="load_consignee_${consigneeCounter}" id="load_consignee_${consigneeCounter}" data-row="${consigneeCounter}" required>
                        <option value="">Select Consignee</option>
                        @foreach($allConsignees as $get)
                            <option value="{{ $get->consignee_name }}" data-id="{{ $get->id }}">{{ $get->consignee_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" name="load_consignee_location_${consigneeCounter}" id="load_consignee_location_${consigneeCounter}" readonly>
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" type="datetime-local" name="load_consignee_appointment_${consigneeCounter}">
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" name="load_consignee_type_${consigneeCounter}">
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" name="load_consignee_commodity_${consigneeCounter}" required>
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" name="load_consignee_qty_${consigneeCounter}">
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" type="number" name="load_consignee_weight_${consigneeCounter}">
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" required type="number" name="load_consignee_value_${consigneeCounter}">
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" name="load_consignee_po_numbers_${consigneeCounter}">
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" type="number" name="load_consignee_contact_${consigneeCounter}">
                </td>
                <td style="padding: 7px;">
                    <input class="form-control" name="load_consignee_discription_${consigneeCounter}">
                </td>
                <td style="padding: 7px;">
                    <textarea class="form-control" name="load_consignee_notes_${consigneeCounter}"></textarea>
                </td>
                <td style="padding: 7px;">
                    <a href="javascript:void(0);" class="btn-remove-consignee" data-row="consigneeRow${consigneeCounter}"><i style="color:red;" class="fa fa-trash"></i></a>
                </td>
            </tr>`;

            // Append new row to the table
            $('#consigneeTable tbody').append(newRow);
            $('#consignee_count').val(consigneeCounter); // Update hidden input for total count
            updateSrNo(); // Update Sr. No after adding new row
        });

        // Remove consignee row
        $(document).on('click', '.btn-remove-consignee', function () {
            const rowId = $(this).data('row');
            $('#' + rowId).remove(); // Remove the row
            updateSrNo(); // Update Sr. No after removal
            consigneeCounter--; // Decrement the counter to maintain accurate counting
            $('#consignee_count').val(consigneeCounter); // Update the hidden input field
        });

        // Fetch consignee details
        $(document).on('change', '.consignee-select', function () {
            const consigneeId = $(this).find(':selected').data('id');
            const rowId = $(this).attr('id').replace('load_consignee_', '');

            if (consigneeId) {
                $.ajax({
                    url: "{{ route('fetch.consignee.details.edit') }}",
                    method: "GET",
                    data: { id: consigneeId },
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            $('#load_consignee_location_' + rowId).val(`${data.consignee_address}, ${data.consignee_city}, ${data.consignee_state}, ${data.consignee_zip}, ${data.consignee_country}`);
                        } else {
                            console.error('No data found for this Consignee.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });

        // Pre-fill consignee data on load
        @foreach ($consigneeData as $key => $consignee)
            $('#load_consignee_{{ $key + 1 }}').val('{{ $consignee['name'] }}').trigger('change');
            $('#load_consignee_location_{{ $key + 1 }}').val('{{ $consigneeLocation[$key]['location'] ?? '' }}'); // Keep the existing location
        @endforeach

        // Update Sr. No for existing rows on load
        updateSrNo();
    });
</script>

<script>
    $(document).on('change', '.consignee-select', function () {
        var consigneeId = $(this).find(':selected').data('id'); // Get the selected consignee ID
        var rowId = $(this).attr('id').split('_')[2]; // Get the row counter

        console.log('Selected Consignee ID:', consigneeId); // Debugging log
        console.log('Selected Consignee Name:', $(this).val()); // Debugging log

        if (consigneeId) {
            // Show loading indicator
            $('#loadingIndicator').show();

            $.ajax({
                url: "{{ route('fetch.consignee.details.edit') }}",
                method: "GET",
                data: { id: consigneeId },
                dataType: "json",
                success: function (data) {
                    // Hide loading indicator
                    $('#loadingIndicator').hide();
                    
                    if (data) {
                        $('#load_consignee_location_' + rowId).val(data.consignee_address + ', ' + data.consignee_city + ', ' + data.consignee_state + ', ' + data.consignee_zip + ', ' + data.consignee_country);
                    } else {
                        console.error('No data found for this Consignee.');
                    }
                },
                error: function (xhr, status, error) {
                    // Hide loading indicator
                    $('#loadingIndicator').hide();
                    
                    console.error(error);
                    alert('An error occurred while fetching consignee details. Please try again later.');
                }
            });
        } else {
            $('#load_consignee_location_' + rowId).val('');
            alert('Please select the Consignee name.'); // This alerts when no consignee is selected
        }
    });
</script>




<script>
    $(document).ready(function () {
        // Add a click event listener to the "Add Charge" button
        $('#addChargeBtn').click(function () {
            // Close the modal with the specified ID
            $('#myModal').modal('hide');
        });
    });

</script>


<script>
    $(function () {
        function fetchCarrierNames(query) {
            if (query.trim() !== '') {
                $.ajax({
                    url: "{{ route('fetch.carrier.names') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    dataType: "json",
                    success: function (response) {
                        var html = '';
                        response.forEach(function (carrierName) {
                            html += '<div class="item" data-value="' + carrierName +
                                '">' +
                                carrierName + '</div>';
                        });
                        $('#carrierList').html(html);
                    }
                });
            } else {
                $('#carrierList').html('');
            }
        }

        $('#load_carrier').keyup(function () {
            var query = $(this).val();
            fetchCarrierNames(query);
        });

        // Listen for click event on carrier list items
        $(document).on('click', '#carrierList .item', function () {
            var selectedCarrier = $(this).text();
            $('#load_carrier').val(selectedCarrier);
            $('#carrierList').html(''); // Clear the list
        });
    });

</script>



<script>
    $(document).ready(function () {
        // When the customer dropdown changes
        $('#load_bill_to').on('change', function () {
            // Get the selected customer ID
            var selectedCustomerId = $(this).val();
            // Set the hidden input field with the customer ID
            $('#customer_id').val(selectedCustomerId);
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('#addChargeBtn').click(function () {
            // Clone the hidden template row
            var newRow = $('#chargeRowTemplate').clone();
            // Remove the id attribute and set display to block
            newRow.removeAttr('id').show();
            // Append the new row to the container
            $('#chargeRowsContainer').append(newRow);
        });

        // Function to remove input row
        $(document).on('click', '.remove-row', function () {
            $(this).closest('.row').remove();
        });
    });

</script>


<script>
    $(document).ready(function () {


        // Add new charge row
        $('#add_charge').click(function () {
            // Clone the hidden template row
            var newRow = $('#chargeRowTemplate').clone();
            // Remove the id attribute and set display to block
            newRow.removeAttr('id').show();
            // Append the new row to the container
            $('#container').append(newRow);
        });

        // Function to remove charge row
        $(document).on('click', '.remove-charge', function () {
            $(this).closest('.row').remove();
        });
    });

</script>




<script>
    $(document).ready(function () {
        // Function to calculate total charges
        function calculateTotal() {
            let total = 0;
            $('.otheramount').each(function () {
                let amount = parseFloat($(this).val()) || 0;
                total += amount;
            });
            $('#carrier_total_other_charge').val(total.toFixed(2));
        }

        // Function to add a new input row
        $('.create-input').click(function () {
            // Clone the hidden template row
            var inputRow = $('#chargeRowTemplatecarrier').clone();
            // Remove the id attribute and display the row
            inputRow.removeAttr('id').show();
            // Append the new row to the container
            $('#inputs').append(inputRow);
            // Recalculate total amount after adding a new row
            calculateTotal();
        });

        // Function to remove an input row
        $(document).on('click', '.closebtn, .remove-charge', function () {
            $(this).closest('.row').remove();
            // Recalculate total amount after removing a row
            calculateTotal();
        });

        // Recalculate total amount when the page loads or when inputs are changed
        $(document).on('input', '.otheramount', function () {
            calculateTotal();
        });

        // Initial calculation on page load
        calculateTotal();
    });

</script>
<script>
    // Function to calculate the total charge
    function calculateTotalCharge() {
        var total = 0;
        // Loop through all the charge-amount inputs
        $('input[name="shipperchargeAmount[]"]').each(function() {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                total += value;
            }
        });
        // Update the total charge field
        $('#shipper_total_other_charge').val(total.toFixed(2));
    }

    // Event listener for changes in any charge-amount input
    $(document).on('input', 'input[name="shipperchargeAmount[]"]', function() {
        calculateTotalCharge();
    });

    // Remove row event
    $(document).on('click', '.remove-row', function() {
        $(this).closest('.row').remove();
        calculateTotalCharge(); // Recalculate the total after removing a row
    });

    // On page load, calculate the total (for pre-filled values)
    $(document).ready(function() {
        calculateTotalCharge();
    });
</script>
<script>
    // File upload handler (if needed)
    document.getElementById('attachment').addEventListener('change', function() {
        // Handle file upload logic here
        console.log(this.files[0]); // Access the uploaded file
    });

    // Print function
    function printFile() {
        // Add your print logic here
        window.print(); // Example: Opens the print dialog
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        // Function to validate input for numbers and decimals only
        function validateInput(input, errorSpan) {
            $(input).on('input', function () {
                let value = $(this).val();
                let isValid = /^[0-9]*\.?[0-9]*$/.test(value); // Regular expression to allow numbers and decimals
                
                if (!isValid) {
                    $(errorSpan).show(); // Show error if invalid input
                } else {
                    $(errorSpan).hide(); // Hide error if valid input
                }
            });
        }

        // Apply validation for load_shipper_rate
        validateInput('#load_shipper_rate', '#error_load_shipper_rate');

        // Apply validation for load_carrier_fee
        validateInput('#load_carrier_fee', '#error_load_carrier_fee');
    });
</script>


<script>
    $(function () {
        let customers = [];
        let previousFinalRate = ''; // Store the previous value of shipper_load_final_rate

        // Function to fetch customer names based on the query
        function fetchCustomerNames(query) {
            if (query.trim().length <= 3) {
                $.ajax({
                    url: "{{ route('fetch.customer.details') }}", //APi get customers and listing
                    method: "GET",
                    data: { query: query },
                    dataType: "json",
                    success: function (response) {
                        customers = response; // Store response data in the customers variable
                        let customerList = response.map(customer => customer.customer_name).join('\n'); // Generate customer list
                        $('#customerList').val(customerList.trim()); // Set the textarea content
                        $('#customerList').show(); // Show the textarea
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching customer details:', error);
                    }
                });
            } else {
                $('#customerList').val(''); // Clear the content of the textarea if query length is less than three
                $('#customerList').hide(); // Hide the textarea
            }
        }

            // Restrict typing to 3 words and show error message
            $('#load_bill_to').on('input', function () {
                
                let value = $(this).val();

                // Restrict input to 3 characters
                if (value.length > 3) {
                    // Block additional characters beyond the 3rd character
                    $(this).val(value.slice(0, 3)); // Keep only the first 3 characters

                    // Show the error message and alert
                    $('#customerErrorMessage').show();
                    // alert('Please select from the customer list.');
                } else if (/\d/.test(value)) {
                    // Prevent numeric input in the field
                    $(this).val(value.replace(/\d/g, '')); // Remove numeric characters from the input
                    alert('Numbers are not allowed');
                } else {
                    // Hide the error message if 3 characters or less
                    $('#customerErrorMessage').hide();
                }

                // If the input is empty, hide the customer list
                if (value.trim() === '' && value.length > 1 && value.trim() > 1) {
                    $('#customerList').hide(); // Hide the customer list when the input is empty
                } else {
                    fetchCustomerNames(value); // Fetch customer names if the input has value
                }
            });


        // Handle click event on customer names inside the textarea
        $(document).on('click', '#customerList', function () {
            var selectedCustomerName = $(this).val().split('\n')[0]; // Get the first selected customer name
            var selectedCustomer = customers.find(customer => customer.customer_name === selectedCustomerName);
            if (selectedCustomer) {
                $('#load_bill_to').val(selectedCustomer.customer_name); // Fill the input with the selected customer name
                $('#customer_id').val(selectedCustomer.id); // Fill the hidden input with the customer id
                $('#remaining_credit').val(selectedCustomer.remaining_credit); // Fill the hidden input with remaining credit
            }
            $('#customerList').hide(); // Hide the textarea after selection
        });

        // Trigger customer fetching on keyup event
        $('#load_bill_to').keyup(function () {
            var query = $(this).val();
            fetchCustomerNames(query);
            if (query.trim() === '') {
                $('#customer_id').val(''); // Clear the customer id if load_bill_to is empty
                $('#remaining_credit').val(''); // Clear remaining credit if load_bill_to is empty
            }
        });

        // Function to check if shipper_load_final_rate exceeds the remaining credit
        function checkFinalRate() {
            var finalRate = parseFloat($('#shipper_load_final_rate').val());
            var remainingCredit = parseFloat($('#remaining_credit').val());

            if (!isNaN(finalRate) && !isNaN(remainingCredit)) {
                if (finalRate > remainingCredit) {
                    alert('Limit Exceeded');
                    $('#shipper_load_final_rate').val(''); // Optionally clear the value if the limit is exceeded
                }
            }
        }

        // Use setInterval to periodically check for changes in shipper_load_final_rate
        setInterval(function () {
        
            var currentFinalRate = $('#shipper_load_final_rate').val();
            if (currentFinalRate !== previousFinalRate) {
                previousFinalRate = currentFinalRate;
                checkFinalRate();
            }
        }, 1000); // Check every second

        // Ensure that checkFinalRate is also called when the final rate input loses focus
        $('#shipper_load_final_rate').blur(checkFinalRate);
    });
</script>



<script>
    $(document).ready(function () {
            // Function to fetch carrier suggestions based on any input (name, MC number, DOT number)
            function fetchCarrierSuggestions(field, inputValue) {
            $.ajax({
                url: '{{ route('fetch.carrier.suggestions') }}',
                method: 'POST',
                data: {
                    field: field,          // Specify the field (name, MC, DOT)
                    inputValue: inputValue, // User input
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    let carrierList = $('#carrier-list');
                    carrierList.empty(); 

                    if (response.length > 0) {
                        response.forEach(function (carrier) {
                            carrierList.append('<li class="list-group-item carrier-item" data-id="' + carrier.id + '">' + carrier.carrier_name + ' - MC: ' + carrier.mcNumber + ', DOT: ' + carrier.dotNumber + '</li>');
                        });
                        carrierList.show();
                    } else {
                        carrierList.hide();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching carrier suggestions: ", error);
                }
            });
        }


        // Function to fetch full carrier details once a carrier is selected
        function fetchCarrierDetails(carrierId) {
            $.ajax({
                url: '{{ route('fetch.carrier.details') }}',
                method: 'POST',
                data: {
                    carrierId: carrierId, 
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response) {
                        $('#carrier_id').val(response.id);
                        $('#load_carrier').val(response.carrier_name);
                        $('#carrier_mc_ff_input').val(response.mcNumber);
                        $('#carrier_dot').val(response.dotNumber);
                        $('#load_carrier_phone').val(response.phone);
                    }
                    $('#carrier-list').hide(); 
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching carrier details: ", error);
                }
            });
        }


        // Event handler for input fields to trigger carrier suggestions
        function handleInputChange() {
            let inputValue = $(this).val();
            let field = $(this).attr('id');

            if (inputValue.length >= 3) {
                fetchCarrierSuggestions(field, inputValue);
            } else {
                $('#carrier-list').hide();
            }
        }

        // Attach the event to all relevant fields (carrier name, MC number, DOT number)
        $('#load_carrier, #carrier_mc_ff_input, #carrier_dot').on('input', handleInputChange);

        // Handle selection of a carrier from the suggestion list
        $(document).on('click', '.carrier-item', function () {
            let carrierId = $(this).data('id');
            fetchCarrierDetails(carrierId); // Fetch the full carrier details
        });

        // Hide the suggestion list when clicking outside the input fields
        $(document).click(function (e) {
            if (!$(e.target).closest('#load_carrier, #carrier_mc_ff_input, #carrier_dot, #carrier-list').length) {
                $('#carrier-list').hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Hide the success message after 1 second (1000 milliseconds)
        setTimeout(function() {
            $('#successMessage').fadeOut('slow');
        }, 1000);

        // Hide the error message after 1 second (1000 milliseconds)
        setTimeout(function() {
            $('#errorMessage').fadeOut('slow');
        }, 1000);
    });
</script>

<script>
    const pasteBox = document.getElementById("paste-no-event");
    pasteBox.onpaste = e => {
    e.preventDefault();
    return false;
    };

</script>
<script>
    // Disable copy and paste on the input field
    document.getElementById('load_bill_to').addEventListener('paste', function (event) {
        event.preventDefault(); // Prevent paste action
        alert('Paste is not allowed'); // Display an error message
    });

    document.getElementById('load_bill_to').addEventListener('copy', function (event) {
        event.preventDefault(); // Prevent copy action
        alert('Copy is not allowed'); // Display an error message
    });

    // Optionally, disable cut as well
    document.getElementById('load_bill_to').addEventListener('cut', function (event) {
        event.preventDefault(); // Prevent cut action
        alert('Cut is not allowed'); // Display an error message
    });
</script>




@endsection
