@extends('layouts.broker.app')
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
    .card-title {
        font-size: 13px;
        text-align: left;
        font-weight: 700;
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

</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important">
            <h2>Load Data </h2>
        </div>

        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form method="POST" action="{{ route('broker.load.update', ['id' => $post->id]) }}"
                                id="myFormLoad" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h3 class="card-title" style="font-size:13px;">Add Load</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Load Number <code>*</code></label>
                                                <input class="form-control" name="load_number" disabled
                                                    value="{{ $post->load_number }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Bill To <code>*</code>&nbsp;
                                                    <a href="{{ route('customer') }}" target="blank"
                                                        style="background: none; border: none;">
                                                        <i class="fa fa-plus mr-1"></i>Add New
                                                    </a>
                                                </label>
                                                <input type="text" id="load_bill_to" name="load_bill_to"
                                                    class="form-control" placeholder="Search Customer names..."
                                                    autocomplete="off" value="{{ $post->load_bill_to }}">
                                                <input id="customerList" class="form-control" style="display: none;"
                                                    readonly></input>
                                                <input type="hidden" id="customer_id" name="customer_id"
                                                    value="{{ $post->customer_id }}">


                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Dispatcher <code>*</code></label>
                                                <input class="form-control" name="load_dispatcher"
                                                    value="{{ $post->user->name }}" required readonly
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control select2" name="load_status"
                                                    style="width: 100%;">
                                                    <option selected="selected" value="{{ $post->load_status }}">
                                                        {{ $post->load_status }}</option>
                                                    <option>Open</option>
                                                    <option>Covered</option>
                                                    <option>Dispatched</option>
                                                    <option>Loading</option>
                                                    <option>On Route</option>
                                                    <option>Un loading</option>
                                                    <option>Deliverd</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Work Order </label>
                                                <input class="form-control" name="load_workorder"
                                                    value="{{ $post->load_workorder }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Payment Type <code>*</code></label>
                                                <select class="form-control select2" required name="load_payment_type"
                                                    style="width: 100%;">
                                                    <option selected="selected" value="{{ $post->load_payment_type }}">
                                                        {{ $post->load_payment_type }}"</option>
                                                    <option>Prepaid</option>
                                                    <option>Postpaid</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Load type<code>*</code></label>
                                                <div class="select2-purple">
                                                    <select class="form-control select2" name="load_type_two"
                                                        style="width: 100%;" required>
                                                        <option selected="selected" value="{{ $post->load_type_two }}">
                                                            {{ $post->load_type_two }}</option>
                                                        <option value="">Please select load type</option>
                                                        <option>OTR</option>
                                                        <option>DRAYAGE</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <input class="form-control" name="load_type"
                                                    value="{{ $post->load_type }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipper Rate <code>*</code></label>
                                                <input type="number" class="form-control number value"
                                                    name="load_shipper_rate" id="load_shipper_rate" required
                                                    value="{{ $post->load_shipper_rate }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>F.S.C Rate % <input hidden type="checkbox"
                                                        name="calculate_fsc_percentage"
                                                        id="calculate_fsc_percentage"></label>
                                                <input class="form-control number percent" name="load_fsc_rate"
                                                    id="load_fsc_rate" value="{{ $post->load_fsc_rate }}"
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="other_charge">Other Change &nbsp; <i class="fa fa-plus"
                                                        data-toggle="modal" data-target="#myModal"
                                                        id="load_shipper_other_charges"></i>
                                                </label>
                                                <input class="form-control" style="width: 100%;">
                                            </div>
                                            <div class="modal close_shipper_other_charges_form" id="myModal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Shipper Other Charges</h4>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <div class="modal-body">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="shipperchargeType">Charge
                                                                                Type:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="shipperchargeType[]"
                                                                                value="{{ $post->load_other_change }} "
                                                                                placeholder="Enter charge type">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Charge
                                                                                Amount:</label>
                                                                            <input type="number" class="form-control"
                                                                                name="shipperchargeAmount[]"
                                                                                placeholder="Enter charge amount"
                                                                                value="{{ $post->load_other_change }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row" id="chargeRowTemplate"
                                                                    style="display: none;">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="shipperchargeType">Charge
                                                                                Type:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="shipperchargeType[]"
                                                                                placeholder="Enter charge type">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Charge
                                                                                Amount:</label>
                                                                            <input type="number" class="form-control"
                                                                                name="shipperchargeAmount[]"
                                                                                placeholder="Enter charge amount">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-success"
                                                                id="addChargeBtn">Add
                                                                Charge</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Final Shipper Rate</label>
                                                <!-- <input class="form-control" disabled name="shipper_load_final_rate" id="shipper_load_final_rate" value="{{ $post->shipper_load_final_rate }}" style="width: 100%;"> -->
                                                <input type="text" class="form-control" name="shipper_load_final_rate"
                                                    id="shipper_load_final_rate"
                                                    value="{{ $post->shipper_load_final_rate }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>MC No <code>*</code></label>
                                                <input class="form-control" required name="load_mc_no"
                                                    id="carrier_mc_ff_input" style="width: 100%;"
                                                    placeholder="Enter MC Number" value="{{ $post->load_mc_no }}">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier <code>*</code></label>
                                                <!-- <input type="text" id="load_carrier" name="load_carrier" class="form-control" style="width: 100%;" value="{{ $post->load_carrier }}" disabled> -->
                                                <input type="text" id="load_carrier" name="load_carrier"
                                                    value="{{ $post->load_carrier }}" class="form-control"
                                                    style="width: 100%;" readonly>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier Phone<code>*</code></label>
                                                <!-- <input type="text" id="load_carrier_phone" name="load_carrier_phone" class="form-control" style="width: 100%;" value="{{ $post->load_carrier_phone }}" disabled> -->
                                                <input type="text" id="load_carrier_phone" name="load_carrier_phone"
                                                    value="{{ $post->load_carrier_phone }}" class="form-control"
                                                    style="width: 100%;" readonly>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Advance Payment</label>
                                                <input class="form-control" name="load_advance_payment"
                                                    value="{{ $post->load_advance_payment }}" style="width: 100%;"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier Fee <code>*</code></label>
                                                <input class="form-control" type="number" name="load_carrier_fee"
                                                    id="load_carrier_fee" value="{{ $post->load_carrier_fee }}" required
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>FSC Rate %</label>
                                                <input type="text" name="load_billing_fsc_rate"
                                                    id="load_billing_fsc_rate" class="form-control"
                                                    value="{{ $post->load_billing_fsc_rate }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="other_charge">Other Charges <i class="fa fa-plus"
                                                        id="openModalIcon"></i> </label>

                                                <input class="form-control" name="load_other_charge"
                                                    style="width: 100%;">
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="otherChargesModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" id="model_content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Other
                                                                Charges
                                                            </h5>
                                                            <!-- <input type="text" disabled name="totalothercharge" id="totalothercharge"> -->
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Add content for the modal body -->
                                                            <div class="container" id="container">
                                                                <div class="row" id="chargeRowTemplate"
                                                                    style="margin-top: 10px;">
                                                                    <!-- Existing code for the first row -->

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input type="text"
                                                                                class="form-control typeofcharge"
                                                                                placeholder="Please enter type of charges"
                                                                                name="inputBox1[]"
                                                                                value="{{ $post->load_other_charge }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <div class="form-group">
                                                                            <input type="text" value="="
                                                                                class="form-control"
                                                                                style="border: unset;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <input type="number"
                                                                                class="form-control otheramount"
                                                                                placeholder="Please enter amount"
                                                                                name="inputBox2[]"
                                                                                value="{{ $post->load_other_charge }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <a type="button"
                                                                            class="btn btn-sm btn-danger remove-charge">
                                                                            <i class="fa fa-window-close"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-info"
                                                                    id="add_charge">Add
                                                                    Charge</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Final Carrier Fee</label>
                                                <input class="form-control" readonly name="load_final_carrier_fee"
                                                    value="{{ $post->load_final_carrier_fee }}"
                                                    id="load_final_carrier_fee" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select class="form-control select2" name="load_currency"
                                                    style="width: 100%;">
                                                    <option selected="selected" value="{{ $post->load_carrier_fee }}">
                                                        {{ $post->load_carrier_fee }}</option>
                                                    <option>$</option>
                                                    <option>CAD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Equipment Type <code>*</code></label>
                                                <select class="form-control select2" required name="load_equipment_type"
                                                    style="width: 100%;">
                                                    <option selected="selected"
                                                        value="{{ $post->load_equipment_type }}">
                                                        {{ $post->load_equipment_type }}</option>
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Delivery Order</label>
                                                <input class="form-control" type="file" readonly
                                                    name="load_delivery_do_file" id="load_delivery_do_file"
                                                    style="width: 100%;padding: 3px 5px"
                                                    value="{{ $post->load_delivery_do_file }}">
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
                                    $shipperCounter = 1;

                                    // Consignee Data Initialization
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
                                    $consigneeDeliveryNotes = json_decode($post->load_consignee_delivery_notes, true) ??
                                    [];
                                    $consigneePoNumber = json_decode($post->load_consignee_po_numbers, true) ?? [];
                                    $consigneeContact = json_decode($post->load_consigneer_contact, true) ?? [];
                                    $allShippers = app(\App\Models\Shipper::class)->where('user_id',
                                    auth()->id())->get();
                                    $consigneeCounter = 1;
                                    @endphp

                                    <div class="table-responsive">
                                        <button id="btnAddShipper" type="button" class="btn btn-primary mt-4"
                                            style="padding: 4px 6px;font-size: 12px;">
                                            <i class="fa fa-plus" style="font-size: 10px;"></i> Add Shipper
                                        </button>
                                        <table class="table table-bordered" id="shipperTable">
                                            <thead>
                                                <tr>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">Sr.
                                                        No</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Shipper</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Shipper Location</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Shipper Appointment</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Commodity Type</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Commodity Name</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">Qty
                                                    </th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Weight (lbs)</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Value ($)</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">PO
                                                        Numbers</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Contact</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Shipper Description</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Shipper Notes</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $shipperCounter = 1; @endphp
                                                @foreach ($shipperData as $key => $shipper)
                                                <tr id="shipperRow{{ $shipperCounter }}">
                                                    <td style="padding: 7px;">S {{ $shipperCounter }}</td>
                                                    <td>
                                                        <select class="form-control"
                                                            name="load_shipper{{ $shipperCounter }}"
                                                            id="load_shipper{{ $shipperCounter }}" required>
                                                            <option value="">Select Shipper</option>
                                                            @foreach($allShippers as $get)
                                                            <option value="{{ $get->id }}"
                                                                {{ (isset($currentShipper) && $currentShipper == $get->id) ? 'selected' : '' }}>
                                                                {{ $get->shipper_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="padding: 7px;">
                                                        <input class="form-control" readonly
                                                            name="load_shipper_location{{ $shipperCounter }}"
                                                            id="load_shipper_location{{ $shipperCounter }}"
                                                            value="{{ $shipperLocation[$key]['location'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                        type="datetime-local"
                                                        name="load_shipper_appointment{{ $shipperCounter }}"
                                                        value="{{ $shipperAppointment[$key]['appointment'] ?? '' }}">
                                                </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_shipper_commodity_type{{ $shipperCounter }}"
                                                            value="{{ $shipperCommodityType[$key]['commodity_type'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_shipper_commodity{{ $shipperCounter }}"
                                                            value="{{ $shipperCommodity[$key]['commodity'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_shipper_qty{{ $shipperCounter }}"
                                                            value="{{ $shipperQty[$key]['qty'] ?? '' }}"></td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_shipper_weight{{ $shipperCounter }}"
                                                            value="{{ $shipperWeight[$key]['weight'] ?? '' }}"></td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_shipper_value{{ $shipperCounter }}"
                                                            value="{{ $shipperValue[$key]['value'] ?? '' }}"></td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_shipper_po_numbers{{ $shipperCounter }}"
                                                            value="{{ $shipperPONumber[$key]['po_number'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_shipper_contact{{ $shipperCounter }}"
                                                            value="{{ $shipperContact[$key]['contact'] ?? '' }}"></td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_shipper_description{{ $shipperCounter }}"
                                                            value="{{ $shipperDescription[$key]['description'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_shipper_shipping_notes{{ $shipperCounter }}"
                                                            value="{{ $shipperShippingNotes[$key]['notes'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><a href="javascript:void(0);"
                                                            class="btn-remove-shipper"
                                                            data-row="shipperRow{{ $shipperCounter }}"><i
                                                                class="fa fa-trash"></i></a></td>
                                                </tr>
                                                @php $shipperCounter++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="shipper_count" name="shipper_count"
                                            value="{{ $shipperCounter - 1 }}">
                                    </div>

                                    @php
                                    $counter = 1; // Start counter from 1
                                    @endphp

                                    <div class="table-responsive">
                                        <button id="btnAddConsignee" type="button" class="btn btn-primary mt-4"
                                            style="padding: 4px 6px;font-size: 12px;">
                                            <i class="fa fa-plus mr-2" style="font-size: 10px;"></i> Add Consignee
                                        </button>
                                        <table class="table table-bordered" id="consigneeTable">
                                            <thead>
                                                <tr>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">Sr.
                                                        No
                                                    </th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Consignee <code>*</code></th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Consignee Location</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Consignee Appointment</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Commodity Type</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Commodity Name</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">Qty
                                                    </th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Weight
                                                        (lbs)</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Value($)</th>

                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">PO
                                                        Number</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Contact
                                                    </th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Consignee Description</th>
                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Consignee Notes</th>

                                                    <th class="p-0" style="vertical-align: middle;font-size: 12px;">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($consigneeData as $key => $consignee)
                                                <tr id="consigneeRow{{ $consigneeCounter }}">
                                                    <td style="padding: 7px;">C {{ $consigneeCounter }}</td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consignee_{{ $consigneeCounter }}" required
                                                            autocomplete="off" value="{{ $consignee['name'] }}"></td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consignee_location_{{ $consigneeCounter }}"
                                                            value="{{ $consigneeLocation[$key]['location'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            type="datetime-local"
                                                            name="load_consignee_appointment_{{ $consigneeCounter }}"
                                                            value="{{ $consigneeAppointment[$key]['appointment'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consignee_type_{{ $consigneeCounter }}"
                                                            value="{{ $consigneeType[$key]['consignee_type'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consignee_commodity_{{ $consigneeCounter }}"
                                                            value="{{ $consigneeCommodity[$key]['consignee_commodity'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consignee_qty_{{ $consigneeCounter }}"
                                                            value="{{ $consigneeQty[$key]['consignee_qty'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consignee_weight_{{ $consigneeCounter }}"
                                                            value="{{ $consigneeWeight[$key]['consignee_weight'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consignee_value_{{ $consigneeCounter }}"
                                                            value="{{ $consigneeValue[$key]['consignee_value'] ?? '' }}">
                                                    </td>
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consignee_po_numbers_{{ $consigneeCounter }}"
                                                            value="{{ $consigneePoNumber[$key]['consignee_po_number'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consigneer_contact_{{ $consigneeCounter }}"
                                                            value="{{ $consigneeContact[$key]['consignee_contact'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><input class="form-control"
                                                            name="load_consignee_discription_{{ $consigneeCounter }}"
                                                            value="{{ $consigneeDescription[$key]['description'] ?? '' }}">
                                                    </td>
                                                    <td style="padding: 7px;"><textarea class="form-control"
                                                            style="width: auto;font-size: 12px;"
                                                            name="load_consignee_notes_{{ $consigneeCounter }}">{{ isset($consigneeNotes[$key]['load_consignee_notes']) ? htmlspecialchars(trim($consigneeNotes[$key]['load_consignee_notes']), ENT_QUOTES, 'UTF-8') : '' }}</textarea>
                                                    </td>
                                                    <td style="padding: 7px;"><a href="javascript:void(0);"
                                                            class="btn-remove-consignee"
                                                            data-row="consigneeRow{{ $consigneeCounter }}"><i
                                                                class="fa fa-trash"></i></a></td>
                                                </tr>
                                                @php $consigneeCounter++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <input type="hidden" id="consignee_count" name="consignee_count"
                                        value="{{ $consigneeCounter }}">

                                    <div class="modal-footer">
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
</section>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let shipperCounter = {
            {
                $shipperCounter
            }
        }; // Start from the existing count

        $('#btnAddShipper').on('click', function () {
            console.log("Add Shipper Button Clicked");

            // Create a new row
            let newRow = `
                <tr id="shipperRow${shipperCounter}">
                    <td style="padding: 7px;">S ${shipperCounter}</td>
                    <td style="padding: 7px;">
                        <select class="form-control" name="load_shipper${shipperCounter}" id="load_shipper${shipperCounter}" required>
                            <option value="">Select Shipper</option>
                            @foreach($allShippers as $get)
                                <option value="{{ $get->id }}">{{ $get->shipper_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td style="padding: 7px;">
                        <input class="form-control" name="load_shipper_location${shipperCounter}" id="load_shipper_location${shipperCounter}" readonly>
                    </td>
                    <td style="padding: 7px;"><input class="form-control" type="datetime-local" name="load_shipper_appointment${shipperCounter}"></td>
                    <td style="padding: 7px;"><input class="form-control" name="load_shipper_commodity_type${shipperCounter}"></td>
                    <td style="padding: 7px;"><input class="form-control" name="load_shipper_commodity${shipperCounter}"></td>
                    <td style="padding: 7px;"><input class="form-control" name="load_shipper_qty${shipperCounter}"></td>
                    <td style="padding: 7px;"><input class="form-control" name="load_shipper_weight${shipperCounter}"></td>
                    <td style="padding: 7px;"><input class="form-control" name="load_shipper_value${shipperCounter}"></td>
                    <td style="padding: 7px;"><input class="form-control" name="load_shipper_po_numbers${shipperCounter}"></td>
                    <td style="padding: 7px;"><input class="form-control" name="load_shipper_contact${shipperCounter}"></td>
                    <td style="padding: 7px;"><input class="form-control" name="load_shipper_description${shipperCounter}"></td>
                    <td style="padding: 7px;"><input class="form-control" name="load_shipper_shipping_notes${shipperCounter}"></td>
                    <td style="padding: 7px;"><a href="javascript:void(0);" class="btn-remove-shipper" data-row="shipperRow${shipperCounter}"><i class="fa fa-trash"></i></a></td>
                </tr>`;

            $('#shipperTable tbody').append(newRow);

            // Update hidden input
            $('#shipper_count').val(shipperCounter);
            shipperCounter++; // Increment for the next row
        });

        // Remove shipper row
        $(document).on('click', '.btn-remove-shipper', function () {
            console.log("Remove Button Clicked for row: " + $(this).data('row'));
            let rowId = $(this).data('row');
            $('#' + rowId).remove();

            // Update the IDs and names of remaining rows
            $('#shipperTable tbody tr').each(function (index) {
                let newIndex = index + 1;
                $(this).attr('id', `shipperRow${newIndex}`);
                $(this).find('td:first').text(`S ${newIndex}`);

                $(this).find('input, select').each(function () {
                    let name = $(this).attr('name').replace(/\d+/, newIndex);
                    $(this).attr('name', name);
                });

                $(this).find('.btn-remove-shipper').attr('data-row', `shipperRow${newIndex}`);
            });

            // Update hidden input
            $('#shipper_count').val($('#shipperTable tbody tr').length);
        });

        // Fetch shipper details when a shipper is selected
        $(document).on('change', '[id^=load_shipper]', function () {
            var shipperId = $(this).val(); // Get the selected shipper ID
            var rowId = $(this).attr('id').replace('load_shipper', ''); // Get the row identifier

            if (shipperId) {
                $.ajax({
                    url: "{{ route('fetch.shipper.details.edit') }}", // Your route to fetch shipper details
                    method: "GET",
                    data: {
                        id: shipperId
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            // Fill in the related fields with fetched data
                            $('#load_shipper_location' + rowId).val(data.shipper_address +
                                ', ' + data.shipper_city + ', ' + data.shipper_state +
                                ', ' + data.shipper_zip + ', ' + data.shipper_country);
                        } else {
                            console.error('No data found for this shipper.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                // Clear the fields if no shipper is selected
                $('#load_shipper_location' + rowId).val('');
            }
        });
    });

</script>




<script>
    $(document).ready(function () {
        let consigneeCounter = {
            {
                $consigneeCounter
            }
        }; // Ensure this is set correctly

        // Function to add new consignee row
        $('#btnAddConsignee').on('click', function () {
            // Check for existing rows to set consigneeCounter
            if ($('#consigneeTable tbody tr').length === 0) {
                consigneeCounter = 1; // Start from 1 if no rows
            } else {
                // Find the maximum consigneeCounter from existing rows
                consigneeCounter = Math.max(...$('#consigneeTable tbody tr').map(function () {
                    return parseInt($(this).attr('id').replace('consigneeRow', ''));
                }).get()) + 1; // Increment the highest existing counter
            }

            // Create new row HTML
            let newRow = `
            <tr id="consigneeRow${consigneeCounter}">
                <td style="padding: 7px;">C ${consigneeCounter}</td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_${consigneeCounter}" required autocomplete="off"></td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_location_${consigneeCounter}"></td>
                <td style="padding: 7px;"><input class="form-control" type="datetime-local" name="load_consignee_appointment_${consigneeCounter}"></td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_type_${consigneeCounter}"></td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_commodity_${consigneeCounter}"></td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_qty_${consigneeCounter}"></td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_weight_${consigneeCounter}"></td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_value_${consigneeCounter}"></td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_po_numbers_${consigneeCounter}"></td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_contact_${consigneeCounter}"></td>
                <td style="padding: 7px;"><input class="form-control" name="load_consignee_description_${consigneeCounter}"></td>
                <td style="padding: 7px;"><textarea class="form-control" name="load_consignee_notes_${consigneeCounter}"></textarea></td>
                <td style="padding: 7px;"><a href="javascript:void(0);" class="btn-remove-consignee" data-row="consigneeRow${consigneeCounter}"><i class="fa fa-trash"></i></a></td>
            </tr>`;

            // Append new row to the table
            $('#consigneeTable tbody').append(newRow);

            // Update hidden input for total count
            $('#consignee_count').val(consigneeCounter);
        });

        // Function to remove consignee row
        $(document).on('click', '.btn-remove-consignee', function () {
            let rowId = $(this).data('row');
            $('#' + rowId).remove();

            // Update the consigneeCounter based on the remaining rows
            consigneeCounter = $('#consigneeTable tbody tr').length;

            // Re-index remaining rows
            $('#consigneeTable tbody tr').each(function (index) {
                let newIndex = index + 1; // Start new index from 1
                $(this).attr('id', `consigneeRow${newIndex}`);
                $(this).find('td:first').text(
                    `C ${newIndex}`); // Update the counter in the first cell

                // Update input names
                $(this).find('input, textarea').each(function () {
                    let name = $(this).attr('name').replace(/\d+/,
                        newIndex); // Replace the old index with the new one
                    $(this).attr('name', name);
                });

                // Update the data-row attribute of the remove button
                $(this).find('.btn-remove-consignee').attr('data-row',
                    `consigneeRow${newIndex}`);
            });

            // Update hidden input for total count
            $('#consignee_count').val(consigneeCounter);
        });
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
    $(document).on('change', '[id^=load_shipper]', function () {
        var shipperId = $(this).val(); // Get the selected shipper ID
        var rowId = $(this).attr('id').replace('load_shipper', ''); // Get the row identifier

        if (shipperId) {
            $.ajax({
                url: "{{ route('fetch.shipper.details.edit') }}", // Use the correct route to fetch shipper details
                method: "GET",
                data: {
                    id: shipperId
                },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        // Fill in the related fields with fetched data
                        $('#load_shipper_location' + rowId).val(data.shipper_address +
                            ', ' + data.shipper_city + ', ' + data.shipper_state +
                            ', ' + data.shipper_zip + ', ' + data.shipper_country);
                        // If you have additional fields, set their values here
                    } else {
                        console.error('No data found for this shipper.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            // Clear the fields if no shipper is selected
            $('#load_shipper_location' + rowId).val('');
        }
    });

</script>















<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
@endsection
