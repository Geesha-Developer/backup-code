@extends('layouts.accounts.app')
@section('content')
@if(session('success'))
<div class="alert alert-success" id="successMessage">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger" id="errorMessage">
    <script>
        alert("{{ session('error') }}");

    </script>
    {{ session('error') }}
</div>
@endif
<style>
    .modal-header h5 {
    font-size: 17px;
    text-align: left;
    font-weight: 700;
}
    .card-title {
        font-size: 13px;
        text-align: left;
        font-weight: 700;
    }
    .modal-backdrop {
    background-color: #0000007d;
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
        font-size: 11px;
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
    #view-file #file-list button {
    background: #ffffff;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    border: none;
    width: 100%;
    text-align: left;
    padding: 8px 11px;
    margin-bottom: 10px;
    border-radius: 10px;
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
    margin-bottom: 4px;
    font-weight: 600;
    text-align: left;
    font-size: 13px;
    color: #4a4a4a;
}
.form-control {
    font-weight: 500;
    height: 31px !important;
    font-size: 11px;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}
.form-group {
    margin: 10px 0 4px 0;
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
            <h2><b>Load Data </b></h2>
        </div>

        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                        <form action="{{ route('accounting.update.load', $load->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                 <h3 class="title mt-0" style="font-size:13px;background: #263544;color:#fff;padding: 9px 6px;">Load Details</h3>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Load Number <code>*</code></label>
                                                <input class="form-control" name="load_number" disabled value="{{ $load->load_number }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Bill To <code>*</code>&nbsp;
                                                    <a href="{{ route('customer') }}" target="blank"
                                                        style="background: none; border: none;">
                                                        <i class="fa fa-plus mr-1"></i>Add New
                                                    </a>
                                                </label>
                                                <div class="d-flex">
                                                <input class="form-control" name="load_bill_to" readonly value="{{ $load->load_bill_to }}" style="width: 100%;">

                                                <!-- <select id="load_bill_to" name="load_bill_to" class="form-control"
                                                    required>
                                                    <option value="{{ $load->load_bill_to }}">{{ $load->load_bill_to }}</option>

                                                </select> -->
                                                <button type="button" class="btn btn-primary info" data-toggle="modal" data-target="#information" style="padding: 4px 13px !important;margin-left: 10px;margin-top: 0;"><i class="fa fa-info-circle"></i></button>
                                                </div>
                                                <input type="hidden" id="customer_id" name="customer_id" value="{{ $load->customer_id }}">
                                                <input type="hidden" id="customer_credit_limit"
                                                    name="customer_credit_limit" value="">
                                                <input type="hidden" id="remaining_credit" name="remaining_credit"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Dispatcher <code>*</code></label>
                                                <input class="form-control" name="load_dispatcher" required readonly value="{{ $load->user->name }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Load type<code>*</code></label>
                                                <div class="select2-purple">
                                                    <select class="form-control select2" name="load_type_two" disabled
                                                        style="width: 100%;" required>
                                                        <option value="{{ $load->load_type_two }}">{{ $load->load_type_two }}</option>
                                                        <option value="">Please select load type</option>
                                                        <option>OTR</option>
                                                        <option>DRAYAGE</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Customer r/f# </label>
                                                <input class="form-control" name="customer_refrence_number" value="{{ $load->customer_refrence_number }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Work Order </label>
                                                <input class="form-control" name="load_workorder" value="{{ $load->load_workorder }}" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <input class="form-control" value=" {{ $load->load_type }} " name="load_type" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Payment Type <code>*</code></label>
                                                <select class="form-control select2" required name="load_payment_type" style="width: 100%;">
                                                    <option value="{{ $load->load_payment_type }}">{{ $load->load_payment_type }}</option>
                                                    <option>Prepaid</option>
                                                    <option>Postpaid</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select class="form-control select2" name="load_currency" style="width: 100%;">
                                                    <option value="{{ $load->load_currency }}">{{ $load->load_currency }}</option>
                                                    <option>$</option>
                                                    <option>CAD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Equipment Type <code>*</code></label>
                                                <select class="form-control select2" required name="load_equipment_type"
                                                    style="width: 100%;">
                                                    <option value="{{ $load->load_equipment_type }}">{{ $load->load_equipment_type }}</option>
                                                    <option value="22' VAN">22' VAN</option>
                                                    <option value="48' Reefer">48' Reefer</option>
                                                    <option value="53' Reefer">53' Reefer</option>
                                                    <option value="53' VAN">53' VAN</option>
                                                    <option value="Air Freight">Air Freight</option>
                                                    <option value="Anhydros Ammonia">Anhydros
                                                        Ammonia</option>
                                                    <option value="Animal Carrier">Animal Carrier
                                                    </option>
                                                    <option value="Any Equipment">Any Equipment
                                                    </option>
                                                    <option value="Searching Services only">Any
                                                        Equipment (Searching
                                                        Services
                                                        only)</option>
                                                    <option value="Auto Carrier">Auto Carrier
                                                    </option>
                                                    <option value="B-Train/Supertrain">
                                                        B-Train/Supertrain</option>
                                                    <option value="Canada Only">B-Train/Supertrain
                                                        (Canada Only)</option>
                                                    <option value="Beam">Beam</option>
                                                    <option value="Belly Dump">Belly Dump</option>
                                                    <option value="Blanket Wrap Van">Blanket Wrap
                                                        Van</option>
                                                    <option value="Boat Hauling Trailer">Boat
                                                        Hauling Trailer</option>
                                                    <option value="Cargo Van (1 Ton)">Cargo Van (1
                                                        Ton)</option>
                                                    <option value="Cargo Vans (1 Ton capacity)">
                                                        Cargo Vans (1 Ton capacity)
                                                    </option>
                                                    <option value="Cargo/Small/Sprinter Van">
                                                        Cargo/Small/Sprinter Van
                                                    </option>
                                                    <option value="Conestoga">Conestoga</option>
                                                    <option value="Container Trailer">Container
                                                        Trailer</option>
                                                    <option value="Convertible Hopper">Convertible
                                                        Hopper</option>
                                                    <option value="Conveyor Belt">Conveyor Belt
                                                    </option>
                                                    <option value="Crane Truck">Crane Truck</option>
                                                    <option value="Curtain Siders">Curtain Siders
                                                    </option>
                                                    <option value="Curtain Van">Curtain Van</option>
                                                    <option value="Double Drop">Double Drop</option>
                                                    <option value="Double Drop Extendable">Double
                                                        Drop Extendable</option>
                                                    <option value="Drive Away">Drive Away</option>
                                                    <option value="Dump Trucks">Dump Trucks</option>
                                                    <option value="End Dump">End Dump</option>
                                                    <option value="Flat Intermodal">Flat Intermodal
                                                    </option>
                                                    <option value="Flat with Traps">Flat with Traps
                                                    </option>
                                                    <option value="FlatBed">FlatBed</option>
                                                    <option value="FlatBed - Air-ride">FlatBed -
                                                        Air-ride</option>
                                                    <option value="Flatbed Blanket Wrapped">Flatbed
                                                        Blanket Wrapped</option>
                                                    <option value="Flatbed Intermodal">Flatbed
                                                        Intermodal</option>
                                                    <option value="Flatbed or Step Deck">Flatbed or
                                                        Step Deck</option>
                                                    <option value="Flatbed or Van">Flatbed or Van
                                                    </option>
                                                    <option value="Flatbed or Vented Van">Flatbed or
                                                        Vented Van</option>
                                                    <option value="Flatbed Over-Dimension Loads">
                                                        Flatbed Over-Dimension
                                                        Loads
                                                    </option>
                                                    <option value="Flatbed With Sides">Flatbed With
                                                        Sides</option>
                                                    <option value="Flatbed, Step Deck or Van">
                                                        Flatbed, Step Deck or Van
                                                    </option>
                                                    <option value="Flatbed, Van or Reefer">Flatbed,
                                                        Van or Reefer</option>
                                                    <option value="Flatbed, Vented Van or Reefer">
                                                        Flatbed, Vented Van or
                                                        Reefer
                                                    </option>
                                                    <option value="Haul and Tow Unit">Haul and Tow
                                                        Unit</option>
                                                    <option value="Hazardous Material Load">
                                                        Hazardous Material Load</option>
                                                    <option value="Hopper Bottom">Hopper Bottom
                                                    </option>
                                                    <option value="Hot Shot">Hot Shot</option>
                                                    <option value="Labour">Labour</option>
                                                    <option value="Landoll Flatbed">Landoll Flatbed
                                                    </option>
                                                    <option value="Live Bottom Trailer">Live Bottom
                                                        Trailer</option>
                                                    <option value="Load-Out">Load-Out</option>
                                                    <option value="Load-Out are empty trailers you load and haul">
                                                        Load-Out
                                                        are
                                                        empty trailers you load and haul</option>
                                                    <option value="Lowboy">Lowboy</option>
                                                    <option value="Lowboy Over-Dimension Loads">
                                                        Lowboy Over-Dimension Loads
                                                    </option>
                                                    <option value="Maxi or Double Flat Trailers">
                                                        Maxi or Double Flat
                                                        Trailers
                                                    </option>
                                                    <option value="Mobile Home">Mobile Home</option>
                                                    <option value="Moving Van">Moving Van</option>
                                                    <option value="Multi-Axle Heavy Hauler">
                                                        Multi-Axle Heavy Hauler</option>
                                                    <option value="Ocean Freight">Ocean Freight
                                                    </option>
                                                    <option value="Open Top">Open Top</option>
                                                    <option value="Open Top Van">Open Top Van
                                                    </option>
                                                    <option value="Pneumatic">Pneumatic</option>
                                                    <option value="Power Only">Power Only</option>
                                                    <option value="Power Only (Tow-Away)">Power Only
                                                        (Tow-Away)</option>
                                                    <option value="Rail">Rail</option>
                                                    <option value="Reefer Pallet Exchange">Reefer
                                                        Pallet Exchange</option>
                                                    <option value="Refrigerated (Reefer)">
                                                        Refrigerated (Reefer)</option>
                                                    <option value="Refrigerated Carrier with Plant Decking">
                                                        Refrigerated
                                                        Carrier
                                                        with Plant Decking</option>
                                                    <option value="Refrigerated Intermodal">
                                                        Refrigerated Intermodal</option>
                                                    <option value="Removable Goose Neck">Removable
                                                        Goose Neck</option>
                                                    <option value="Multi-Axle Heavy Haulers">
                                                        Removable Goose Neck &amp;
                                                        Multi-Axle Heavy Haulers</option>
                                                    <option value="GN Extendable">RGN Extendable
                                                    </option>
                                                    <option value="Roll Top Conestoga">Roll Top
                                                        Conestoga</option>
                                                    <option value="Roller Bed">Roller Bed</option>
                                                    <option value="Specialized Trailers">Specialized
                                                        Trailers</option>
                                                    <option value="Step Deck">Step Deck</option>
                                                    <option value="Step Deck Conestoga">Step Deck
                                                        Conestoga</option>
                                                    <option value="Step Deck Extendable">Step Deck
                                                        Extendable</option>
                                                    <option value="Step Deck or Flat">Step Deck or
                                                        Flat</option>
                                                    <option value="Step Deck or Removable Gooseneck">
                                                        Step Deck or Removable
                                                        Gooseneck</option>
                                                    <option value="Step Deck Over-Dimension Loads">
                                                        Step Deck Over-Dimension
                                                        Loads</option>
                                                    <option value="Step Deck with Loading Ramps">
                                                        Step Deck with Loading
                                                        Ramps
                                                    </option>
                                                    <option value="Straight Van">Straight Van
                                                    </option>
                                                    <option value="Stretch Trailer or Ext. Flat">
                                                        Stretch Trailer or Ext.
                                                        Flat
                                                    </option>
                                                    <option value="Stretch Trailer or Extendable Flatbed">
                                                        Stretch Trailer or
                                                        Extendable Flatbed</option>
                                                    <option value="Supplies">Supplies</option>
                                                    <option value="Tandem Van">Tandem Van</option>
                                                    <option value="Tanker">Tanker</option>
                                                    <option value="Tanker (Food grade, liquid, bulk, etc.)">
                                                        Tanker (Food
                                                        grade,
                                                        liquid, bulk, etc.)</option>
                                                    <option value="Team Driver Needed">Team Driver
                                                        Needed</option>
                                                    <option value="Tridem">Tridem</option>
                                                    <option value="Two 24 or 28 Foot Flatbeds">Two
                                                        24 or 28 Foot Flatbeds
                                                    </option>
                                                    <option value="Unspecified Specialized Trailers">
                                                        Unspecified Specialized
                                                        Trailers</option>
                                                    <option value="Van">Van</option>
                                                    <option value="Van - Air-Ride">Van - Air-Ride
                                                    </option>
                                                    <option value="Van Intermodal">Van Intermodal
                                                    </option>
                                                    <option value="Van or Flatbed">Van or Flatbed
                                                    </option>
                                                    <option value="Van or Reefer">Van or Reefer
                                                    </option>
                                                    <option value="Van Pallet Exchange">Van Pallet
                                                        Exchange</option>
                                                    <option value="Van with Liftgate">Van with
                                                        Liftgate</option>
                                                    <option value="Van, Reefer or Double Drop">Van,
                                                        Reefer or Double Drop
                                                    </option>
                                                    <option value="Vented Insulated Van">Vented
                                                        Insulated Van</option>
                                                    <option value="Vented Insulated Van or Refrigerated">
                                                        Vented Insulated
                                                        Van or
                                                        Refrigerated</option>
                                                    <option value="Vented Van">Vented Van</option>
                                                    <option value="Vented Van or Refrigerated">
                                                        Vented Van or Refrigerated
                                                    </option>
                                                    <option value="Walking Floor">Walking Floor
                                                    </option>
                                                    <option value="BOX Truck">BOX Truck</option>
                                                    <option value="Reefer Container">Reefer
                                                        Container</option>
                                                    <option value="Tandem">Tandem</option>
                                                    <option value="B Train">B Train</option>
                                                    <option value="Flatbed with Tarps">Flatbed with
                                                        Tarps</option>
                                                    <option value="Flatbed with straps">Flatbed with
                                                        straps</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control select2" name="load_status" style="width: 100%;">
                                                <option value="{{ $load->load_status }}">
                                                @if($load->invoice_status == 'Paid')
                                                    <span style="color:green">Invoiced</span>
                                                    @elseif($load->invoice_status == 'Paid Record')
                                                        <span style="color:green">Paid</span>
                                                    @elseif($load->load_status == 'Completed')
                                                    <span style="color:red"> Completed</span>
                                                    @elseif($load->load_status == 'Open')
                                                    <span style="color:red"> Open</span>
                                                    @elseif($load->load_status == 'Unloading')
                                                    <span style="color:red"> Unloading</span>
                                                    @else
                                                        <span style="color:red"> {{ $load->load_status }}</span>
                                                @endif
                                                </option>
                                                    <option>Open</option>
                                                    <option>Covered</option>
                                                    <option>Dispatched</option>
                                                    <option>Loading</option>
                                                    <option>On Route</option>
                                                    <option>Un loading</option>
                                                    <option>Delivered</option>
                                                    <option>Invoiced</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Payment Terms</label>
                                                <select class="form-control select2" name="invoicing_payment_terms" style="width: 100%;">
                                                    <option value="Net 30" {{ $load->invoicing_payment_terms == 'Net 30' || empty($load->invoicing_payment_terms) ? 'selected' : '' }}>Net 30</option>
                                                    <option value="Net 7" {{ $load->invoicing_payment_terms == 'Net 7' ? 'selected' : '' }}>Net 7</option>
                                                    <option value="Due On Receipt" {{ $load->invoicing_payment_terms == 'Due On Receipt' ? 'selected' : '' }}>Due On Receipt</option>
                                                </select>
                                            </div>
                                        </div>
                                     </div>
                                     
                                     <h3 class="title" style="font-size:13px;">Customer
                                     <a href="{{ route('admin.shipper.rc.download.pdf', ['id' => $load->id]) }}" title="Customer RC" target="_blank"><i class="fas fa-file-pdf" aria-hidden="true"  style="color:red; font-size: 24px;"></i>
                                        </a>
                                     </h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Customer Rate <code>*</code></label>
                                                <input type="text" class="form-control number value"
                                                    name="load_shipper_rate" id="load_shipper_rate" required value="{{ $load->load_shipper_rate }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>F.S.C Rate % <input hidden type="checkbox"
                                                        name="calculate_fsc_percentage"
                                                        id="calculate_fsc_percentage"></label>
                                                <input class="form-control number percent" name="load_fsc_rate" value="{{ $load->load_fsc_rate }}" id="load_fsc_rate" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="other_charge">Customer Other Charges &nbsp; <i
                                                        class="fa fa-plus" data-toggle="modal" data-target="#myModal"
                                                        id="load_shipper_other_charges"></i></label>
                                                        <input class="form-control" style="width: 100%;" id="shipper_total_other_charge">
                                                        </div>
                                            <div class="modal close_shipper_other_charges_form" id="myModal">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header pt-0">
                                                            <h5>Customer Other Charges</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <div class="modal-body p-0 pl-3">
                                                            <div class="container">
                                                            @php
                                                                $shipperCharges = json_decode($load->shipper_load_other_charge, true);
                                                                if (json_last_error() !== JSON_ERROR_NONE || !is_array($shipperCharges)) {
                                                                    // Handle JSON error or invalid data
                                                                    $shipperCharges = [];
                                                                }

                                                                $carrierCharges = json_decode($load->carrier_load_other_charge, true);
                                                                if (json_last_error() !== JSON_ERROR_NONE || !is_array($carrierCharges)) {
                                                                    // Handle JSON error or invalid data
                                                                    $carrierCharges = [];
                                                                }
                                                            @endphp
                                                                    <div class="row" style="margin-top: 19px;">
                                                                        <div class="col-md-6">
                                                                                <label for="shipperchargeType">Charge Type:</label>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                                <label>Amount:</label>
                                                                        </div>
                                                                    </div>
                                                                @foreach($shipperCharges as $index => $shipperCharge)
                                                                    <div class="row">
                                                                        <div class="col-md-6" style="margin-top: 12px;">
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control"
                                                                                    name="shipperchargeType[]"
                                                                                    value="{{ htmlspecialchars($shipperCharge['type'] ?? '') }}"
                                                                                    placeholder="Enter Charge Type">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5" style="margin-top: 12px;">
                                                                            <div class="form-group">
                                                                                <input type="text" step="0.01" class="form-control" name="shipperchargeAmount[]" value="{{ number_format(floatval($shipperCharge['amount'] ?? 0), 2) }}" placeholder="Enter Amount">
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-1" style="margin-top: 22px;">
                                                                            <button class="remove-row"
                                                                                    style="background:unset;border:none"
                                                                                    type="button"><i style=" color:red;"
                                                                                    class="fa fa-trash"></i></button>
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
                                                                    <div class="col-md-6" style="margin-top: 12px;">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                name="shipperchargeType[]"
                                                                                placeholder="Enter Charge Type">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5" style="margin-top: 12px;">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                name="shipperchargeAmount[]"
                                                                                placeholder="Enter Amount">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1" style="margin-top: 22px;">
                                                                        <button class="remove-row" type="button"
                                                                            style="background:unset;border:none"><i
                                                                                style="color:red;"
                                                                                class="fa fa-trash"></i></button>
                                                                    </div>
                                                                </div>

                                                                <!-- Container for new rows -->
                                                                <div id="chargeRowsContainer"></div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal Footer -->
                                                        <div class="text-center mt-4">
                                                            <button type="button" class="btn btn-success" style="padding: 6px 27px;font-size: 14px;"
                                                                id="addChargeBtn">Add New Charges</button>
                                                        </div>
                                                        <!-- Modal Footer -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Customer Final Rate</label>
                                                <!-- <input type="number" id="shipper_load_final_rate" name="shipper_load_final_rate" class="form-control" required> -->
                                                <input type="text" class="form-control" readonly id="shipper_load_final_rate" value="{{ $load->shipper_load_final_rate }}" name="shipper_load_final_rate" required data-readonly />
                                            </div>
                                        </div>
                                    </div>
                                      <h3 class="title" style="font-size:13px;background: #263544;color:#fff;">Carrier
                                      <a href="{{ route('admin.rc.download.pdf', ['id' => $load->id]) }}" title="Carrier RC" target="_blank"><i class="fas fa-file-pdf" aria-hidden="true" style="color:red;font-size: 24px;"></i>
                                        </a>
                                      </h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier <code>*</code></label>
                                                <div class="d-flex">
                                                <input type="text" id="load_carrier" name="load_carrier" value="{{ $load->load_carrier }}" class="form-control" style="width: 100%;" readonly>
                                                <button type="button" class="btn btn-primary info" data-toggle="modal" data-target="#carrier-detail" style="padding: 4px 13px !important;margin-left: 10px;margin-top: 0;" ><i class="fa fa-info-circle"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>MC No <code>*</code></label>
                                                <input class="form-control" required name="load_mc_no"  value="{{ $load->load_mc_no }}" id="carrier_mc_ff_input" style="width: 100%;" readonly
                                                    placeholder="Enter MC Number">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>DOT No <code>*</code></label>
                                                <input class="form-control"  name="carrier_dot" id="carrier_dot" style="width: 100%;" readonly placeholder="Enter DOT Number" value="{{ $load->carrier_dot }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier Phone<code>*</code></label>
                                                <input type="text" id="load_carrier_phone" name="load_carrier_phone" value="{{ $load->load_carrier_phone }}" class="form-control" style="width: 100%;" readonly>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Billing Type</label>
                                                <select class="form-control select2" name="load_billing_type" disabled
                                                    style="width: 100%;">
                                                    <option value="{{ $load->load_billing_type }}">{{ $load->load_billing_type }}</option>
                                                    <option>Factoring</option>
                                                    <option>Direct Billing</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Carrier Rate <code>*</code></label>
                                                <input class="form-control" type="text" name="load_carrier_fee" value="{{ $load->load_carrier_fee }}" id="load_carrier_fee" required style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>FSC Rate %</label>
                                                <input type="text" name="load_billing_fsc_rate" value="{{ $load->load_billing_fsc_rate }}" id="load_billing_fsc_rate" class="form-control" style="width: 100%;">
                                            </div>
                                        </div>
                                        @php
                                        $carrierCharges = json_decode($load->carrier_load_other_charge, true);
                                        @endphp
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="other_charge">Carrier Other Charges <i class="fa fa-plus" data-toggle="modal" data-target="#otherChargesModal"></i></label>
                                                <!-- <input type="text" class="form-control" style="width: 100%;" name="carrier_total_other_charge" id="carrier_total_other_charge"> -->
                                                <input type="text" class="form-control" style="width: 100%;" name="carrier_total_other_charge" id="carrier_total_other_charge">
     
                                            </div>
     
                                            <div class="modal fade" id="otherChargesModal">
                                                <div class="modal-dialog modal-lg" >
                                                    <div class="modal-content" id="model_content">
                                                        <div class="modal-header pt-0">
                                                            <h5 id="exampleModalLabel">Carrier Other Charges</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body p-0 pl-2">
                                                            <div class="container">
                                                            @php
                                                                // Decode the JSON data and check for errors
                                                                $carrierCharges = json_decode($load->carrier_load_other_charge, true);
                                                                if (json_last_error() !== JSON_ERROR_NONE || !is_array($carrierCharges)) {
                                                                    // Handle JSON error or invalid data
                                                                    $carrierCharges = [];
                                                                }
                                                            @endphp
                                                                    <div class="row" style="margin-top: 19px;">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Charge Type:</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="form-group">
                                                                                <label>Amount:</label>                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @foreach($carrierCharges as $index => $carrierCharge)
                                                                    <div class="row charge-row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control typeofcharge" placeholder="Enter Charges Type" name="shipper_type_charge[]" value="{{ htmlspecialchars($carrierCharge['type'] ?? '') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="form-group">
                                                                                <input type="text" step="0.01" class="form-control otheramount" placeholder="Enter Amount" name="shipper_other_charge[]" value="{{ isset($carrierCharge['amount']) ? number_format((float) $carrierCharge['amount'], 2) : '0.00' }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1" style="margin-top: 12px;">
                                                                            <a type="button" style="background:unset;border:none" class="remove-charge">
                                                                                <i class="fa fa-trash" style="color:red;" aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
     
     
                                                                <!-- Container for dynamically added fields -->
                                                                <div id="inputs"></div>
                                                            </div>
     
                                                            <div class="text-center mt-4">
                                                                <button type="button" class="btn btn-success create-input" style="padding: 6px 27px;font-size: 14px;">Add New Charges</button>
                                                            </div>
                                                        </div>
     
                                                        <!-- Hidden template row for cloning -->
                                                        <div id="chargeRowTemplatecarrier" style="display:none;">
                                                            <div class="row charge-row" style="margin-top: 10px;">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control typeofcharge" placeholder="Enter Charges Type" name="shipper_type_charge[]">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control otheramount" placeholder="Enter Amount" name="shipper_other_charge[]">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1" style="margin-top: 12px;">
                                                                    <button class="closebtn" style="border: none; background: unset; color:red;">
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
                                                <input class="form-control"  name="load_final_carrier_fee" readonly value="{{ $load->load_final_carrier_fee }}" id="load_final_carrier_fee" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Advance Payment</label>
                                                <input class="form-control" name="load_advance_payment" readonly value="{{ $load->load_advance_payment }}" style="width: 100%;" autocomplete="off">
                                            </div>
                                        </div>
                                        
                                        
                                       
                                        

                                    @php
                                    // Shipper Data Initialization
                                    $shipperData = json_decode($load->load_shipperr, true) ?? [];
                                    $shipperQty = json_decode($load->load_shipper_qty, true) ?? [];
                                    $shipperWeight = json_decode($load->load_shipper_weight, true) ?? [];
                                    $shipperDescription = json_decode($load->load_shipper_discription, true) ?? [];
                                    $shipperType = json_decode($load->load_shipper_commodity_type, true) ?? [];
                                    $shipperNotes = json_decode($load->load_shipper_shipping_notes, true) ?? [];
                                    $shipperContact = json_decode($load->load_shipper_contact, true) ?? [];
                                    $shipperLocation = json_decode($load->load_shipper_location, true) ?? [];
                                    $shipperAppointment = json_decode($load->load_shipper_appointment, true) ?? [];
                                    $shipperCommodity = json_decode($load->load_shipper_commodity, true) ?? [];
                                    $shipperValue = json_decode($load->load_shipper_value, true) ?? [];
                                    $shipperPoNumber = json_decode($load->load_shipper_po_numbers, true) ?? [];
                                    $allShippers = app(\App\Models\Shipper::class)->where('user_id',
                                    auth()->id())->get();
                                    $shipperCounter = count($shipperData) + 1; // Adjust counter based on existing data
                                    @endphp

                                    <div class="table-responsive p-3">
                                        <!-- <button id="btnAddShipper" type="button" class="btn btn-primary mt-4"
                                            style="padding: 4px 6px; font-size: 12px;">
                                            <i class="fa fa-plus" style="font-size: 10px;"></i> Add Shipper
                                        </button> -->
                                        <table class="table table-bordered" id="shipperTable">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;font-size: 12px;">Sr.
                                                        No</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Shipper <code>*</code></th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Shipper Location</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Appointment</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Commodity Type</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Commodity Name<code>*</code></th>
                                                    <th style="vertical-align: middle;font-size: 12px;">Qty
                                                    </th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Weight (lbs)</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Value ($) <code>*</code></th>
                                                    <th style="vertical-align: middle;font-size: 12px;">PO
                                                        Numbers</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Contact</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Description</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Shipper Notes</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($shipperData as $key => $shipper)
                                                    <tr id="shipperRow{{ $key + 1 }}">
                                                        <td style="padding: 7px;">S {{ $key + 1 }}</td>
                                                        <td style="padding: 7px;">
                                                            <!-- <select class="form-control load_shipper shipper-select" style="width:200px;" name="load_shipper_{{ $key + 1 }}" id="load_shipper_{{ $key + 1 }}" required>
                                                                <option value="{{ $shipper['name'] }}">{{ $shipper['name'] }}</option>
                                                                <option value="">Select Shipper</option>
                                                                @foreach($allShippers as $get)
                                                                <option value="{{ $get->shipper_name }}" data-id="{{ $get->id }}">{{ $get->shipper_name }}</option>
                                                                @endforeach
                                                            </select> -->
                                                            <input type="text" style="width: 200px;" class="form-control load_shipper shipper-select" value="{{ $shipper['name'] }}" readonly name="load_shipper_{{ $key + 1 }}" id="load_shipper_{{ $key + 1 }}" data-row="{{ $key + 1 }}" required>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 480px;" value="{{ $shipperLocation[$key]['location'] ?? '' }}" title="{{ $shipperLocation[$key]['location'] ?? '' }}" 
                                                            name="load_shipper_location_{{ $key + 1 }}" id="load_shipper_location_{{ $key + 1 }}" readonly>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" type="datetime-local" name="load_shipper_appointment_{{ $key + 1 }}" value="{{ $shipperAppointment[$key]['appointment'] ?? '' }}" readonly>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 160px;" name="load_shipper_type_{{ $key + 1 }}" value="{{ isset($shipperType[$key]['commodity_type']) ? $shipperType[$key]['commodity_type'] : ($shipperType[$key]['type'] ?? '') }}" readonly>
                                                        </td>

                                                        <td style="padding: 7px;">
                                                            <input class="form-control" name="load_shipper_commodity_{{ $key + 1 }}" value="{{ isset($shipperCommodity[$key]['commodity_name']) ? $shipperCommodity[$key]['commodity_name'] : ($shipperCommodity[$key]['commodity'] ?? '') }}" readonly  required>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 87px;" type="number" name="load_shipper_qty_{{ $key + 1 }}" value="{{ isset($shipperQty[$key]['shipper_qty']) ? $shipperQty[$key]['shipper_qty'] : ($shipperQty[$key]['qty'] ?? '0') }}" readonly>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                        <input class="form-control" style="width: 90px;" type="number" name="load_shipper_weight_{{ $key + 1 }}" value="{{ isset($shipperWeight[$key]['shipper_weight']) ? $shipperWeight[$key]['shipper_weight'] : ($shipperWeight[$key]['weight'] ?? '0') }}" readonly>

                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 90px;" required type="number" name="load_shipper_value_{{ $key + 1 }}" value="{{ isset($shipperValue[$key]['shipper_value']) ? $shipperValue[$key]['shipper_value'] : ($shipperValue[$key]['value'] ?? '0') }}" readonly>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 130px;" name="load_shipper_po_numbers_{{ $key + 1 }}" value="{{ isset($shipperPoNumber[$key]['shipping_po_numbers']) ? $shipperPoNumber[$key]['shipping_po_numbers'] : $shipperPoNumber[$key]['po_number'] ?? '0' }}" readonly>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 131px;" type="number" name="load_shipper_contact_{{ $key + 1 }}" value="{{ $shipperContact[$key]['shipping_contact'] ?? $shipperContact[$key]['contact'] ?? '0' }}" readonly>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <input class="form-control" style="width: 210px;" name="load_shipper_description_{{ $key + 1 }}" value="{{ $shipperDescription[$key]['description'] ?? 'NA' }}" readonly>
                                                        </td>
                                                        <td style="padding: 7px;">
                                                        <textarea style="width: auto; font-size: 12px; border: 1px solid #ced4da; border-radius: .25rem;" name="load_shipper_notes_{{ $key + 1 }}" readonly>
                                                                {{ isset($shipperNotes[$key]['shipping_notes']) ? $shipperNotes[$key]['shipping_notes'] : $shipperNotes[$key]['notes'] ?? 'NA' }}
                                                        </textarea>
                                                        </td>
                                                        <td class="text-center" style="padding: 7px;">
                                                            <a href="javascript:void(0);" class="btn-remove-shipper" data-row="shipperRow{{ $key + 1 }}" style="pointer-events: none; cursor: default;">
                                                                <i class="fa fa-trash" style="color:red"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                        </table>
                                        <input type="hidden" id="shipper_count" name="shipper_count"
                                            value="{{ count($shipperData) }}">
                                    </div>


                                    @php
                                    $counter = 1; // Start counter from 1
                                    $consigneeData = json_decode($load->load_consignee, true) ?? [];
                                    $consigneeQty = json_decode($load->load_consignee_qty, true) ?? [];
                                    $consigneeWeight = json_decode($load->load_consignee_weight, true) ?? [];
                                    $consigneeDescription = json_decode($load->load_consignee_discription, true) ?? [];
                                    $consigneeType = json_decode($load->load_consignee_type, true) ?? [];
                                    $consigneeNotes = json_decode($load->load_consigneer_notes, true) ?? [];
                                    $consigneeLocation = json_decode($load->load_consignee_location, true) ?? [];
                                    $consigneeAppointment = json_decode($load->load_consignee_appointment, true) ?? [];
                                    $consigneeCommodity = json_decode($load->load_consignee_commodity, true) ?? [];
                                    $consigneeValue = json_decode($load->load_consignee_value, true) ?? [];
                                    $consigneeDeliveryNotes = json_decode($load->load_consignee_delivery_notes, true) ??
                                    [];
                                    $consigneePoNumber = json_decode($load->load_consignee_po_numbers, true) ?? [];
                                    $consigneeContact = json_decode($load->load_consigneer_contact, true) ?? [];
                                    $allConsignees = \App\Models\Consignee::where('user_id', auth()->id())->get();
                                    $consigneeCounter = count($consigneeData);
                                    @endphp

                                    <div class="table-responsive p-3">
                                        <!-- <button id="btnAddConsignee" type="button" class="btn btn-primary mt-4"
                                            style="padding: 4px 6px;font-size: 12px;">
                                            <i class="fa fa-plus mr-2" style="font-size: 10px;"></i> Add Consignee
                                        </button> -->
                                        <table class="table table-bordered" id="consigneeTable">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;font-size: 12px;">Sr.
                                                        No</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Consignee <code>*</code></th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Consignee Location</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Appointment</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Commodity Type</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Commodity Name<code>*</code></th>
                                                    <th style="vertical-align: middle;font-size: 12px;">Qty
                                                    </th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Weight (lbs)</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Value($) <code>*</code></th>
                                                    <th style="vertical-align: middle;font-size: 12px;">PO
                                                        Number</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Contact</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Description</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Consignee Notes</th>
                                                    <th style="vertical-align: middle;font-size: 12px;">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($consigneeData as $key => $consignee)
                                                <tr id="consigneeRow{{ $key + 1 }}">
                                                    <td style="padding: 7px;">C {{ $key + 1 }}</td>
                                                    <td style="padding: 7px;">
                                                        <!-- <select class="form-control load_consignee consignee-select"
                                                            name="load_consignee_{{ $key + 1 }}"
                                                            id="load_consignee_{{ $key + 1 }}" data-row="{{ $key + 1 }}"
                                                            required>
                                                            <option value="{{ $consignee['name'] }}">
                                                                {{ $consignee['name'] }}</option>
                                                            <option value="">Select Consignee</option>
                                                            @foreach($allConsignees as $get)
                                                            <option value="{{ $get->consignee_name }}"
                                                                data-id="{{ $get->id }}">{{ $get->consignee_name }}
                                                            </option>
                                                            @endforeach
                                                        </select> -->

                                                        <input type="text" style="width: 200px;" class="form-control load_consignee consignee-select" value="{{ $load->consignee_name }}" readonly name="load_consignee_{{ $key + 1 }}" id="load_consignee_{{ $key + 1 }}" data-row="{{ $key + 1 }}" required>
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control" style="width: 480px;"
                                                            name="load_consignee_location_{{ $key + 1 }}" title="{{ $consigneeLocation[$key]['location'] ?? '' }}"
                                                            id="load_consignee_location_{{ $key + 1 }}"
                                                            value="{{ $consigneeLocation[$key]['location'] ?? '' }}"
                                                            readonly>
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control" type="datetime-local"
                                                            name="load_consignee_appointment_{{ $key + 1 }}"
                                                            value="{{ $consigneeAppointment[$key]['appointment'] ?? '' }}" readonly>
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control" style="width: 160px;"
                                                            name="load_consignee_type_{{ $key + 1 }}"
                                                            value="{{ $consigneeType[$key]['consignee_type'] ?? '' }}" readonly>
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control"
                                                            name="load_consignee_commodity_{{ $key + 1 }}" readonly
                                                            value="{{ $consigneeCommodity[$key]['consignee_commodity'] ?? '' }}"
                                                            required>
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control" style="width: 87px;"
                                                            name="load_consignee_qty_{{ $key + 1 }}" readonly
                                                            value="{{ $consigneeQty[$key]['consignee_qty'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control" style="width: 90px;"
                                                            name="load_consignee_weight_{{ $key + 1 }}" type="number" readonly
                                                            value="{{ $consigneeWeight[$key]['consignee_weight'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control" required style="width: 90px;"
                                                            name="load_consignee_value_{{ $key + 1 }}" type="number" readonly
                                                            value="{{ $consigneeValue[$key]['consignee_value'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control"
                                                            name="load_consignee_po_numbers_{{ $key + 1 }}" style="width: 130px;" readonly
                                                            value="{{ $consigneePoNumber[$key]['consignee_po_number'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control" style="width: 131px;"
                                                            name="load_consigneer_contact_{{ $key + 1 }}" type="number" readonly
                                                            value="{{ $consigneeContact[$key]['consignee_contact'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control" style="width: 210px;"
                                                            name="load_consignee_discription_{{ $key + 1 }}" readonly
                                                            value="{{ $consigneeDescription[$key]['description'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <textarea style="width: auto;font-size: 12px;border: 1px solid #ced4da; border-radius: .25rem;" readonly 
                                                            name="load_consignee_notes_{{ $key + 1 }}">{{ isset($consigneeNotes[$key]['load_consignee_notes']) ? htmlspecialchars(trim($consigneeNotes[$key]['load_consignee_notes']), ENT_QUOTES, 'UTF-8') : '' }}</textarea>
                                                    </td>
                                                    <td class="text-center" style="padding: 7px;">
                                                        <a href="javascript:void(0);" class="btn-remove-consignee" style="pointer-events: none; cursor: default;"
                                                            data-row="consigneeRow{{ $key + 1 }}"><i style="color:red;"
                                                                class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <input type="hidden" id="consignee_count" name="consignee_count">

                                    <div class="modal-footer justify-content-center col-md-12">
                                        @if($load->public_file)
                                            <li>
                                                <a style="padding: 8px 13px; font-size: 14px;" class="btn btn-primary text-white" onclick="openModal({{ $load->id }})" data-toggle="modal" data-target="#view-file"><i class="fa fa-eye" style="margin-right: 10px;"></i>Dispatcher Files</a>
                                            </li>
                                            @else
                                            <li>
                                            <a style="padding: 8px 13px; font-size: 14px;" class="btn btn-primary text-white" href="javascript:void(0);" style="text-decoration:unset"> <i class="fa fa-eye-slash" style="margin-right: 10px; font-size: 20px;"></i>No files Uploded </a>
                                            </li>
                                        @endif
                                        <input type="submit" class="btn btn-info" value="Save" onclick="saveFormData()">
                                        <a href="{{ route('accounts') }}" class="btn btn-danger" data-dismiss="modal">Cancel</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="carrier-detail">
     <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body pt-2">
               
                    <div class="card-header p-0">
                        <button type="button" class="close" style="top: -5px;"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h3 class="card-title">Carrier Details</h3>
                    </div>

                    <div class="card-body pb-3 text-left">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Carrier Name <code>*</code></label>
                                    <input class="form-control select2" required readonly name="carrier_name" style="width: 100%;" value="{{ $load->carrier->carrier_name ?? '' }}">
                                    </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mr-2">M.C. #/F.F.#
                                        <code>*</code></label>
                                        <input type="text" class="form-control select2" required name="carrier_mc_ff_input" id="carrier_mc_ff_input" readonly value="{{ $load->carrier->carrier_mc_ff_input ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>D.O.T</label>
                                    <input class="form-control" name="carrier_dot" readonly value="{{ $load->carrier->carrier_dot ?? '' }}" style="width: 100%; ">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address<code>*</code></label>
                                    <input class="form-control" required readonly value="{{ $load->carrier->carrier_address_two ?? '' }}" name="carrier_address_two" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Country<code>*</code></label>
                                    <input class="form-control" readonly required name="carrier_country" id="country" value="{{ preg_replace('/^\d+\s*/', '', $load->carrier->carrier_country ?? '') }}" style="width: 100%;">
                                    </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>State<code>*</code></label>
                                    <input class="form-control" readonly required name="carrier_state" id="state" style="width: 100%; " value="{{ $load->carrier->carrier_state ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>City<code>*</code></label>
                                    <input class="form-control" name="carrier_city" required readonly value="{{ $load->carrier->carrier_city ?? '' }}" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Zip<code>*</code></label>
                                    <input class="form-control" type="number" name="carrier_zip" required readonly id="carrier_zip" style="width: 100%;" value="{{ $load->carrier->carrier_zip ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>POC Name</label>
                                    <input class="form-control" name="carrier_contact_name" value="{{ $load->carrier->carrier_contact_name ?? '' }}" readonly style="width: 100%; ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" name="carrier_email" value="{{ $load->carrier->carrier_email ?? '' }}" readonly style="width: 100%; ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Telephone<code>*</code></label>
                                    <input type="number" class="form-control" name="carrier_telephone" value="{{ $load->carrier->carrier_telephone ?? '' }}" required readonly id="carrier_telephone" style="width: 100%; ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Extn. </label>
                                    <input class="form-control" name="carrier_extn" value="{{ $load->carrier->carrier_extn ?? '' }}" readonly style="width: 100%; ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input class="form-control" name="carrier_fax" value="{{ $load->carrier->carrier_fax ?? '' }}" readonly style="width: 100%; ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status <code>*</code></label>
                                    <input class="form-control" name="carrier_status" value="{{ $load->carrier->carrier_status ?? '' }}" readonly style="width: 100%; ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Payment Terms </label>
                                    <input class="form-control" name="carrier_payment_terms" value="{{ $load->carrier->carrier_payment_terms ?? '' }}" readonly style="width: 100%; ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Factoring Company </label>
                                    <input class="form-control" name="carrier_factoring_company" value="{{ $load->carrier->carrier_factoring_company ?? '' }}" readonly style="width: 100%; ">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label
                                        style="margin-bottom: 0; font-weight: 600;color: #4a4a4a;">Notes</label>
                                    <textarea class="form-control" name="carrier_notes" readonly style="width: 100%; height: 70px !important">{{ $load->carrier->carrier_notes ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</section>
<div class="modal" id="view-file">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Files</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul id="file-list" class="p-0"></ul>
                <!-- <button id="mergeButton" type="button" class="btn btn-primary"><i class="fa fa-file-pdf-o"></i> Merge
                    Documents</button> -->
            </div>
        </div>

    </div>
</div> 
<div class="modal" id="information">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header pt-2">
            <h3 class="card-title head m-0">CUSTOMER DETAILS</h3>
            </div>
            <div class="modal-body pt-0 pb-3">
            <form method="POST" action="{{ route('customer_insert') }}" id="myForm" class="hide" enctype="multipart/form-data">
                <div class="card-body text-left">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Customer Name </label>
                                <input class="form-control select2" type="text" readonly name="customer_name" id="customer_name" value="{{ $load->customer->customer_name ?? '' }}" style="width: 100%;height:30px ;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <input type="text" name="user_id" hidden>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mr-2">MC# /FF# <code id="mc_ff_code" style="display: none;">*</code></label>
                                <div class="d-flex" style="width: 100%;">
                                    <input class="form-control select2" readonly name="customer_mc_ff_input" id="customer_mc_ff_input" value="{{ $load->customer->customer_mc_ff_input ?? '' }}" style="width: 100%; height:30px !important;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address </label>
                                <input type="text" class="form-control select2" readonly name="customer_address" id="customer_address" value="{{ $load->customer->customer_address ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px;  ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Country </label>
                                <input class="form-control select2" readonly name="customer_country" id="country" value="{{ preg_replace('/^\d+\s*/', '', isset($load->customer->customer_country) ? $load->customer->customer_country : '') }}" style="width: 100%; height:30px !important;">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>State </label>
                                <input class="form-control select2" readonly name="customer_state" id="state" value="{{ $load->customer->customer_state ?? '' }}" style="width: 100%; height:30px !important;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>City </label>
                                <input type="text" class="form-control select2" readonly name="customer_city" id="customer_city" value="{{ $load->customer->customer_city ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Zip </label>
                                <input type="number" class="form-control select2" readonly name="customer_zip" id="customer_zip" value="{{ $load->customer->customer_zip ?? '' }}" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Billing Address </label>
                                <input type="text" class="form-control select2" readonly type="text" name="customer_billing_address" value="{{ $load->customer->customer_billing_address ?? '' }}" id="customer_billing_address" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Billing City </label>
                                <input type="text" class="form-control select2" readonly name="customer_billing_city" value="{{ $load->customer->customer_billing_city ?? '' }}" id="customer_billing_city" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Billing State </label>
                                <input type="text" class="form-control select2" readonly name="customer_billing_state" value="{{ $load->customer->customer_billing_state ?? '' }}" id="customer_billing_state" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Billing Zip </label>
                                <input type="number" class="form-control select2" readonly name="customer_billing_zip" value="{{ $load->customer->customer_billing_zip ?? '' }}" id="customer_billing_zip" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Billing Country </label> 
                                <input type="text" class="form-control select2" readonly type="text" name="customer_billing_country" value="{{ $load->customer->customer_billing_country ?? '' }}" id="customer_billing_country" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>POC Name</label>
                                <input type="text" class="form-control select2" readonly name="customer_primary_contact" value="{{ $load->customer->customer_primary_contact ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telephone </label>
                                <input type="number" maxlimit="12" class="form-control select2" readonly name="customer_telephone" value="{{ $load->customer->customer_telephone ?? '' }}" id="customer_telephone" placeholder="Number Only" style="width: 100%; height: 30px; padding: 0px 0 0 10px;" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Extn. </label>
                                <input type="text" class="form-control select2" readonly name="customer_extn" value="{{ $load->customer->customer_extn ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email </label>
                                <input type="email" class="form-control select2" readonly name="customer_email"  value="{{ $load->customer->customer_email ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Website URL </label>
                                <input class="form-control select2" name="adv_customer_webiste_url" readonly id="adv_customer_webiste_url" value="{{ $load->customer->adv_customer_webiste_url ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fax</label>
                                <input type="text" class="form-control select2" readonly name="customer_fax" value="{{ $load->customer->customer_fax ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Acc Pay Email</label>
                                <input type="email" class="form-control select2" readonly name="customer_secondary_email" value="{{ $load->customer->customer_secondary_email ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>AP Contact</label>
                                <input type="number" class="form-control select2" readonly name="customer_billing_telephone" value="{{ $load->customer->customer_billing_telephone ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>AP Extn.</label>
                                <input type="text" class="form-control select2" readonly name="customer_billing_extn" value="{{ $load->customer->customer_billing_extn ?? '' }}" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group align-items-center">
                                <label class="mr-2">Status </label>
                                <input type="text" class="form-control select2" readonly name="customer_status" value="{{ $load->customer->customer_status ?? '' }}" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header mt-4 p-0">
                    <h3 class="card-title head m-0">ADVANCED</h3>
                </div>
                <div class="card-body text-left">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Currency Setting </label>
                                <input type="text" class="form-control select2" readonly name="adv_customer_currency_Setting" value="{{ $load->customer->adv_customer_currency_Setting ?? '' }}" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                       
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sales Rep. <code>*</code></label>
                                <input type="text" class="form-control select2" name="adv_customer_sales_rep" readonly value="{{ $load->load_dispatcher ?? '' }}" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                    </div>
            </form>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
         
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>
    function openModal(recordId) {
        $.ajax({
            url: '/get-files/' + recordId,
            method: 'GET',
            success: function (response) {
                var fileList = $('#file-list');
                fileList.empty();
                if (response.files && response.files.length > 0) {
                    $.each(response.files, function (index, file) {
                        var iframe = $('<iframe>', {
                            src: file,
                            frameborder: 0,
                            style: 'width: 100%; height: 300px; display: none;'
                        });
                        var listItem = $('<li>').append(iframe);

                        var toggleButton = $('<button>', {
                            text: 'Document File ' + (index + 1),
                            click: function () {
                                iframe.toggle();
                            }
                        });

                        fileList.append(toggleButton).append(listItem);
                    });
                } else {
                    fileList.append('<li>No documents have been uploaded.</li>');
                }

                // Add merge button functionality
                $('#mergeButton').off('click').on('click', function () {
                    mergeFiles(recordId); // Pass recordId to mergeFiles function
                });

                // // Show the modal
                // $('#view-file').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('Error fetching files:', xhr.responseText);
            }
        });
    }

    function mergeFiles(recordId) {
        $.ajax({
            url: '/merge-files',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                recordId: recordId // Pass recordId as data
            },
            success: function (response) {
                if (response.success) {
                    alert('Files merged successfully!');
                    // Open the merged PDF file in a new tab
                    var newTab = window.open(response.url, '_blank');
                    newTab.focus(); // Focus on the new tab
                } else {
                    alert('Failed to merge files: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error merging files:', xhr.responseText);
                alert('Error merging files: ' + xhr.responseText);
            }
        });
    }
</script>
<script>
$(document).ready(function () {
    let shipperCounter = {{ $shipperCounter }}; // Start from the existing count

    // Function to update Sr. No
    function updateSrNo() {
        $('#shipperTable tbody tr').each(function(index) {
            $(this).find('td:first').text(`S ${index + 1}`); // Update Sr. No based on current index
        });
    }

    // Add Shipper Row
    $('#btnAddShipper').on('click', function () {
        shipperCounter++; // Increment counter for new row

        let newRow = `
        <tr id="shipperRow${shipperCounter}">
            <td style="padding: 7px;">S ${shipperCounter}</td>
            <td>
                <select class="form-control load_shipper" name="load_shipper${shipperCounter}" id="load_shipper${shipperCounter}" required>
                    <option value="">Select Shipper</option>
                    @foreach($allShippers as $get)
                        <option value="{{ $get->shipper_name }}" data-id="{{ $get->id }}" data-location="{{ $get->location }}">
                            {{ $get->shipper_name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td style="padding: 7px;">
                <input class="form-control" readonly name="load_shipper_location${shipperCounter}" id="load_shipper_location${shipperCounter}" title="">
            </td>
            <td style="padding: 7px;">
                <input class="form-control" type="datetime-local" name="load_shipper_appointment${shipperCounter}">
            </td>
            <td style="padding: 7px;">
                <input class="form-control" name="load_shipper_commodity_type${shipperCounter}">
            </td>
            <td style="padding: 7px;">
                <input class="form-control" name="load_shipper_commodity${shipperCounter}" required>
            </td>
            <td style="padding: 7px;">
                <input type="number" class="form-control" name="load_shipper_qty${shipperCounter}">
            </td>
            <td style="padding: 7px;">
                <input type="number" class="form-control" name="load_shipper_weight${shipperCounter}">
            </td>
            <td style="padding: 7px;">
                <input type="number" class="form-control" required name="load_shipper_value${shipperCounter}">
            </td>
            <td style="padding: 7px;">
                <input class="form-control" name="load_shipper_po_numbers${shipperCounter}">
            </td>
            <td style="padding: 7px;">
                <input class="form-control" name="load_shipper_contact${shipperCounter}">
            </td>
            <td style="padding: 7px;">
                <input class="form-control" name="load_shipper_description${shipperCounter}">
            </td>
            <td style="padding: 7px;">
                <textarea class="form-control" name="load_shipper_shipping_notes${shipperCounter}"></textarea>
            </td>
            <td style="padding: 7px;">
                <a href="javascript:void(0);" class="btn-remove-shipper" data-row="shipperRow${shipperCounter}"><i style="color:red;" class="fa fa-trash"></i></a>
            </td>
        </tr>`;

        // Append new row to the table
        $('#shipperTable tbody').append(newRow);
        $('#shipper_count').val(shipperCounter); // Update hidden input for total count
        updateSrNo(); // Update Sr. No after adding new row
    });

    // Remove shipper row
    $(document).on('click', '.btn-remove-shipper', function () {
        const rowId = $(this).data('row');
        $('#' + rowId).remove(); // Remove the row
        shipperCounter--; // Decrease counter
        $('#shipper_count').val(shipperCounter); // Update shipper count
        updateSrNo(); // Update Sr. No after removal
    });

    // Fetch shipper details
    $(document).on('change', '.load_shipper', function () {
        const shipperId = $(this).find(':selected').data('id');
        const rowId = $(this).attr('id').replace('load_shipper', '');

        if (shipperId) {
            $.ajax({
                url: "{{ route('fetch.shipper.details.edit') }}",
                method: "GET",
                data: { id: shipperId },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        $('#load_shipper_location' + rowId).val(`${data.shipper_address}, ${data.shipper_city}, ${data.shipper_state}, ${data.shipper_zip}, ${data.shipper_country}`);
                    } else {
                        console.error('No data found for this Shipper.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    // Pre-fill shipper data on load
    @foreach ($shipperData as $key => $shipper)
        $('#load_shipper{{ $key + 1 }}').val('{{ $shipper['name'] }}').trigger('change');
        $('#load_shipper_location{{ $key + 1 }}').val('{{ $shipperLocation[$key]['location'] ?? '' }}'); // Keep the existing location
    @endforeach

    // Update Sr. No for existing rows on load
    updateSrNo();
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
                <input class="form-control" name="load_consignee_location_${consigneeCounter}" id="load_consignee_location_${consigneeCounter}" readonly >
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
                <input class="form-control" name="load_consignee_description_${consigneeCounter}">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#carrier_mc_ff_input').on('input', function () {
            var mcNumber = $(this).val();
            if (mcNumber.trim() !== '') {
                $.ajax({
                    url: "{{ route('fetch.carrier.details') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        mcNumber: mcNumber
                    },
                    success: function (response) {
                        if (response) {
                            $('#load_carrier').val(response.carrier_name);
                            $('#load_carrier_phone').val(response.carrier_telephone);
                        } else {
                            $('#load_carrier').val('No data found');
                            $('#load_carrier_phone').val('');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#load_carrier').val('Error fetching data');
                        $('#load_carrier_phone').val('');
                    }
                });
            } else {
                $('#load_carrier').val('');
                $('#load_carrier_phone').val('');
            }
        });
    });

</script>







<script>
    $(document).ready(function () {
        $('#load_bill_to').select2({
            placeholder: "Select Customer",
            allowClear: true,
            ajax: {
                url: "{{ route('fetch.customer.details') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        query: params.term // Search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(customer => ({
                            id: customer.id,
                            text: customer.customer_name // Display name
                        }))
                    };
                },
                cache: true
            },
            minimumInputLength: 2 // Minimum characters before search
        });

        $('#load_bill_to').on('change', function (e) {
            var data = $(this).select2("val");
            $('#customer_id').val(data); // Update the hidden customer_id field
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
        // Function to add input row
        $('.create-input').click(function () {
            var inputRow = $('<div class="row">' +
                '<div class="col-md-6" style="margin-top: 12px;"><div class="form-group"><input class="form-control" style="width:100%;margin-bottom: 5px;" type="text" name="shipper_type_charge[]" placeholder="Enter Charge Type"></div></div>' +
                '<div class="col-md-5" style="margin-top: 12px;"><div class="form-group"><input class="form-control" style="width:100%;margin-bottom: 5px;" type="number" name="shipper_other_charge[]" placeholder="Enter Amount" /></div></div>' +
                '<div class="col-md-1" style="margin-top: 12px;"><a class="closebtn" style="border: none;background: unset;"><i style="color:red;margin-top: 18px;" class="fa fa-trash"></i></a></div>' +
                '</div>');
            $('#inputs').append(inputRow);
        });

        // Function to remove input row
        $(document).on('click', '.closebtn', function () {
            $(this).closest('.row').remove();
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
$(function () {
    let previousFinalRate = ''; // Store the previous value of shipper_load_final_rate

    // Handle change event on load_bill_to select
    $('#load_bill_to').change(function () {
        var selectedOption = $(this).find('option:selected');
        var selectedCustomerId = selectedOption.data('id');
        var selectedCreditLimit = selectedOption.data('credit-limit');
        var selectedRemainingCredit = selectedOption.data('remaining-credit');

        if (selectedOption.val()) {
            $('#customer_id').val(selectedCustomerId);
            $('#customer_credit_limit').val(selectedCreditLimit);
            $('#remaining_credit').val(selectedRemainingCredit); // Set remaining credit value

            // Update display fields
            $('#credit_limit_display').text(selectedCreditLimit); // Display credit limit
            $('#remaining_credit_display').text(selectedRemainingCredit); // Display remaining credit
        } else {
            $('#customer_id').val('');
            $('#customer_credit_limit').val('');
            $('#remaining_credit').val('');
            $('#credit_limit_display').text('');
            $('#remaining_credit_display').text('');
        }
    });

    // Function to check if shipper_load_final_rate exceeds the remaining credit
    function checkFinalRate() {
        var finalRate = parseFloat($('#shipper_load_final_rate').val());
        var remainingCredit = parseFloat($('#remaining_credit').val());

        if (!isNaN(finalRate) && !isNaN(remainingCredit) && finalRate > remainingCredit) {
            alert('Limit Exceeded: The final rate exceeds the remaining credit limit of ' + remainingCredit);
            $('#shipper_load_final_rate').val(''); // Optionally clear the value if the limit is exceeded
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
});
</script>



<script>
    $.ajax({
    url: "{{ route('fetch.customer.details') }}",
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

</script>

<script>
        $(document).ready(function () {
            $('#shipper_other_charge').click(function () {
                $('#shiperotherChargesModal').modal('show');
            });
        });
    </script>


    <!-- actial code  -->
    <script>
        $(document).ready(function () {
            function updateTotal() {
                var total = 0;

                $('[name="shipperchargeAmount[]"]').each(function (index, inputBox) {
                    var amount = parseFloat($(inputBox).val()) || 0;
                    total += amount;
                });

                var loadShipperRate = parseFloat($('#load_shipper_rate').val()) || 0;
                total += loadShipperRate;

                var loadFscRate = parseFloat($('#load_fsc_rate').val()) || 0;
                total += (loadFscRate / 100) * loadShipperRate;

                $('#shipper_load_final_rate').val(total.toFixed(2));
            }

            $(document).on('input', '[name="shipperchargeAmount[]"], #load_shipper_rate, #load_fsc_rate',
                function () {
                    updateTotal();
                });

            // $(document).on('click', '#addChargeBtn', function () {
            //     var newChargeRow = $('#chargeRowTemplate').clone().removeAttr('id').show();
            //     newChargeRow.find('[name="shipperchargeType[]"]').val('');
            //     newChargeRow.find('[name="shipperchargeAmount[]"]').val('');
            //     newChargeRow.appendTo('.container');

            //     updateTotal();
            // });

            // $(document).on('click', '.remove-charge', function () {
            //     $(this).closest('.row').remove();

            //     updateTotal();
            // });
        });
    </script>






    <script>
        $(document).ready(function () {

            // Function to remove input row
            $(document).on('click', '.closebtn', function () {
                var removedAmount = parseFloat($(this).siblings('input[name="shipper_other_charge[]"]')
                    .val()) || 0;
                var total = parseFloat($('#load_final_carrier_fee').val()) || 0;
                total -= removedAmount;
                $('#load_final_carrier_fee').val(total.toFixed(2));

                $(this).parent().remove();
                updateTotal();
            });

            // Function to calculate and update the total amount
            function updateTotal() {
                var total = 0;

                // Iterate through each charge input box
                $('[name="inputBox2[]"], [name="shipper_other_charge[]"]').each(function (index, inputBox) {
                    var amount = parseFloat($(inputBox).val()) || 0;
                    total += amount;
                });

                // Add load_carrier_fee to the total
                var loadCarrierFee = parseFloat($('#load_carrier_fee').val()) || 0;
                total += loadCarrierFee;

                // Get the billing FSC rate
                var billingFSCRate = parseFloat($('#load_billing_fsc_rate').val()) || 0;

                // Calculate the percentage of load_carrier_fee based on billing FSC rate
                var fscAmount = (loadCarrierFee * billingFSCRate) / 100;

                // Add the calculated FSC amount to the total
                total += fscAmount;

                // Set the sum in load_final_carrier_fee
                $('#load_final_carrier_fee').val(total.toFixed(2));
            }

            // Handle input changes to update the total
            $(document).on('input',
                '[name="inputBox2[]"], [name="shipper_other_charge[]"], #load_carrier_fee, #load_billing_fsc_rate',
                function () {
                    updateTotal();
                });
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
    // Function to calculate total charge
    function calculateCarrierTotalCharge() {
        var total = 0;
        // Loop through all charge inputs
        $('input[name="shipper_other_charge[]"]').each(function() {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                total += value;
            }
        });
        // Update total in carrier_total_other_charge field
        $('#carrier_total_other_charge').val(total.toFixed(2));
    }

    // Event listener for changes in charge inputs
    $(document).on('input', 'input[name="shipper_other_charge[]"]', function() {
        calculateCarrierTotalCharge();
    });

    // Remove row event
    $(document).on('click', '.remove-charge', function() {
        $(this).closest('.charge-row').remove();
        calculateCarrierTotalCharge(); // Recalculate total after removing a row
    });

    // On page load, calculate the total (for pre-filled values)
    $(document).ready(function() {
        calculateCarrierTotalCharge();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
</script>

<script>
    document.body.style.zoom = "75%";
</script>

@endsection
