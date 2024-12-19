@extends('layouts.accounts.app')
@section('content')
<style>
    @media (min-width: 576px) {

        select.form-control,
        input#customer_city,
        input#customer_zip,
        input.form-control {
            height: 100% !important;
            font-size: 12px;
        }
    }

    #customerList,
    #shipperList,
    #consigneeList {
        position: absolute;
        z-index: 999;
        width: 95%;

    }

    /* Active item */
    .list-group-item.active {
        color: #fff;
        background-color: #0c7ce6;
        position: absolute;
        z-index: 999;
    }

    /* Inactive items */
    .list-group-item {
        color: #000;
        background-color: #fff;
        position: absolute;
        z-index: 999;
    }

    /* Hover effect for inactive items */
    .list-group-item:not(.active):hover {
        color: #fff;
        background-color: #0c7ce6;
        position: absolute;
        z-index: 999;
    }
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Edit Load</h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i
                            class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Input -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">

                    <div class="card">
                        <div class="body">
                            <form action="{{ route('loads.update', $load->id) }}" method="POST" id="myFormLoad">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h3 class="card-title">Add Load</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Load Number <code>*</code></label>
                                                <input class="form-control" name="load_number" disabled
                                                    value="{{ $load->load_number }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Bill To <code>*</code>&nbsp;<a href="{{ url('/customer') }}"
                                                        id="bill_to_add_request" style="color:#0c7ce6"><i
                                                            class="fa fa-plus"></i> Add New</a>
                                                </label>
                                                <!-- <input class="form-control" name="load_bill_to" required style="width: 100%;"> -->
                                                <!-- <input type="text" id="load_bill_to" class="form-control" required name="load_bill_to" style="width: 100%;" placeholder="Enter Bill To"> -->

                                                <input type="text" id="load_bill_to" name="load_bill_to"
                                                    class="form-control" value="{{ $load->load_bill_to }}"
                                                    placeholder="Search Customer names...">
                                                <textarea id="customerList" class="form-control" style="display: none;"
                                                    readonly></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Dispatcher <code>*</code></label>
                                                <input class="form-control" name="load_dispatcher"
                                                    value="{{ Auth::user()->name }}" required readonly
                                                    style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control select2" name="load_status"
                                                    style="width: 100%;">
                                                    <option selected="selected" value="{{ $load->load_status }}">
                                                        {{ $load->load_status }}</option>
                                                    <option value="Open">Open</option>
                                                    <option value="Covered">Covered</option>
                                                    <option value="Dispatched">Dispatched</option>
                                                    <option value="Loading">Loading</option>
                                                    <option value="On Route">On Route</option>
                                                    <option value="Un loading">Un loading</option>
                                                    <option value="completed">Deliverd</option>
                                                    <option value="completed">completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>W/O # </label>
                                                <input class="form-control" name="load_workorder"
                                                    value="{{ $load->load_workorder }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Payment Type <code>*</code></label>
                                                <select class="form-control select2" required name="load_payment_type"
                                                    style="width: 100%;">
                                                    <option selected="selected">{{ $load->load_payment_type }}</option>
                                                    <option>Prepaid</option>
                                                    <option>Postpaid</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Type <code>*</code></label>
                                                <input class="form-control" required name="load_type"
                                                    value="{{ $load->load_type }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipper Rate <code>*</code></label>
                                                <input type="number" class="form-control number value"
                                                    name="load_shipper_rate" id="load_shipper_rate" required
                                                    value="{{ $load->load_shipper_rate }}" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>P/D s</label>
                                                <input class="form-control" name="load_pds" type="number"
                                                    value="{{ $load->load_pds }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>F.S.C Rate % <input hidden type="checkbox"
                                                        name="calculate_fsc_percentage"
                                                        id="calculate_fsc_percentage"></label>
                                                <input class="form-control number percent" name="load_fsc_rate"
                                                    value="{{ $load->load_fsc_rate }}" id="load_fsc_rate"
                                                    style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Telephone <code>*</code></label>
                                                <input class="form-control" name="load_telephone"
                                                    value="{{ $load->load_telephone }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="other_charge">Other Change &nbsp; <i class="fa fa-plus"
                                                        data-toggle="modal" data-target="#myModal"
                                                        id="load_shipper_other_charges"></i>
                                                </label>
                                            </div>
                                            <div class="modal close_shipper_other_charges_form" id="myModal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Shipper Other
                                                                Charges</h4>
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
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Final Shipper Rate</label>
                                                <input class="form-control result" disabled
                                                    name="shipper_load_final_rate" id="shipper_load_final_rate"
                                                    value="{{ $load->shipper_load_final_rate }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier <code>*</code></label>
                                                <!-- <input type="text" id="searchInput" name="load_carrier" class="form-control" placeholder="Search carrier names..."> -->
                                                <input type="text" id="load_carrier" name="load_carrier"
                                                    class="form-control" style="width: 100%;"
                                                    value="{{ $load->load_carrier }}"
                                                    placeholder="Search carrier names...">

                                                <div id="carrierList"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Advance Payment</label>
                                                <input class="form-control" name="load_advance_payment"
                                                    value="{{ $load->load_advance_payment }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Load type</label>
                                                <div class="select2-purple">
                                                    <select class="form-control select2" name="load_type_two"
                                                        style="width: 100%;">
                                                        <option selected="selected" value="{{ $load->load_type_two }}">
                                                            {{ $load->load_type_two }}</option>
                                                        <option>OTR</option>
                                                        <option>DRAYAGE</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Billing Type</label>
                                                <select class="form-control select2" name="load_billing_type"
                                                    style="width: 100%;">
                                                    <option selected="selected" value="{{ $load->load_billing_type }}">
                                                        {{ $load->load_billing_type }}</option>
                                                    <option>Factoring</option>
                                                    <option>Direct Billing</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>MC No <code>*</code></label>
                                                <!-- <input class="form-control" required name="load_mc_no" style="width: 100%;"> -->
                                                <input class="form-control" required name="load_mc_no"
                                                    id="carrier_mc_ff_input" style="width: 100%;"
                                                    value="{{ $load->load_mc_no }}" placeholder="Enter MC Number">

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Equipment Type <code>*</code></label>
                                                <select class="form-control select2" required name="load_equipment_type"
                                                    style="width: 100%;">
                                                    <option selected="selected"
                                                        value="{{ $load->load_equipment_type }}">
                                                        {{ $load->load_equipment_type }}</option>
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
                                                <label>Carrier Fee <code>*</code></label>
                                                <input class="form-control" type="number" name="load_carrier_fee"
                                                    id="load_carrier_fee" value="{{ $load->load_carrier_fee }}" required
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select class="form-control select2" name="load_currency"
                                                    style="width: 100%;">
                                                    <option selected="selected" value="{{ $load->load_currency }}">
                                                        {{ $load->load_currency }}</option>
                                                    <option>$</option>
                                                    <option>%</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>P/D s <code>*</code></label>
                                                <input class="form-control" name="load_pds_two" required
                                                    value="{{ $load->load_pds_two }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>FSC Rate %</label>
                                                <input type="text" name="load_billing_fsc_rate"
                                                    id="load_billing_fsc_rate" class="form-control"
                                                    value="{{ $load->load_billing_fsc_rate}}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="other_charge">Other Charges <i class="fa fa-plus"
                                                        id="openModalIcon"></i></label>
                                                <!-- <input class="form-control" name="load_other_charge" style="width: 100%;"> -->
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="otherChargesModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" id="model_content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Other Charges
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
                                                                                name="inputBox1[]">
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
                                                                                name="inputBox2[]">
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
                                    </div>


                                    <div class="row">
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label>Final Carrier Fee</label>
                                                <input class="form-control" readonly name="load_final_carrier_fee"
                                                    id="load_final_carrier_fee"
                                                    value="{{ $load->load_final_carrier_fee}}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label>Dilevery Order</label>
                                                <input class="form-control" type="file" readonly
                                                    name="load_delivery_do_file" id="load_delivery_do_file"
                                                    value="{{ $load->load_delivery_do_file}}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <!-- <div class="col-12 col-sm-3">
                                                                <div class="form-group">
                                                                    <label>Rate Coin</label>
                                                                    <input class="form-control" type="file" readonly
                                                                        name="load_rate_coin_file"
                                                                        id="load_rate_coin_file" style="width: 100%;">
                                                                </div>
                                                            </div> -->

                                    </div>

                                </div>
                                <div class="card-header">
                                    <h3 class="card-title">Shipper</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipper <code>*</code> <a href="{{ url('/shipper') }}">Add
                                                        New</a></label>
                                                <!-- <input class="form-control" name="load_shipperr" required style="width: 100%;"> -->
                                                <input class="form-control" name="load_shipper" required
                                                    style="width: 100%;" value="{{ $load->load_shipperr}}">
                                                <!-- <div id="shipperList" class="shipper-list"></div> -->
                                                <!-- <textarea id="shipperList" class="form-control" style="display: none;" readonly></textarea> -->
                                                <ul id="shipperList" class="list-group" style="display: none;">
                                                    <!-- First item with active class -->
                                                    <li class="list-group-item active" style="cursor: pointer; width: 100%;"></li>
                                                </ul>

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input class="form-control" name="load_shipper_location"
                                                    value="{{ $load->load_shipper_location}}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date And Time<code>*</code></label>
                                                <input class="form-control" type="datetime-local"
                                                    value="{{ $load->load_shipper_appointment }}"
                                                    name="load_shipper_appointment" required style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input class="form-control" name="load_shipper_discription"
                                                    value="{{ $load->load_shipper_discription }}" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Commodity Type</label>
                                                <input class="form-control select2" name="load_shipper_commodity_type"
                                                    value="{{ $load->load_shipper_commodity_type }}"
                                                    style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <input class="form-control" name="load_shipper_qty"
                                                    value="{{ $load->load_shipper_qty }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Weight (lbs)</label>
                                                <input class="form-control" name="load_shipper_weight"
                                                    value="{{ $load->load_shipper_weight }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Commodity <code>*</code></label>
                                                <input class="form-control" name="load_shipper_commodity" type="text"
                                                    value="{{ $load->load_shipper_commodity }}" required
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">


                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Value($)<code>*</code></label>
                                                <input class="form-control" name="load_shipper_value" required
                                                    value="{{ $load->load_shipper_value }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Shipping Notes</label>
                                                <input class="form-control" name="load_shipper_shipping_notes"
                                                    value="{{ $load->load_shipper_shipping_notes }}"
                                                    style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>P.O Numbers</label>
                                                <input class="form-control" name="load_shipper_po_numbers"
                                                    value="{{ $load->load_shipper_po_numbers }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                <input class="form-control" type="number" name="load_shipper_contact"
                                                    value="{{ $load->load_shipper_po_numbers }}" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-header">
                                    <h3 class="card-title">Consignee <a href="#" style="color:#000" id="add_consignee">
                                            <i class="fa fa-plus"></i></a></h3>
                                </div>


                                <div class="card-body" id="consigneeSections">
                                    <div class="consignee-section row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Consignee <code>*</code> <a href="{{ url('/consignee') }}">Add
                                                        New</a></label>
                                                <input class="form-control" name="load_consignee" required 
                                                    value="{{ $load->load_consignee }}" style="width: 100%;">
                                                <ul id="consigneeList" class="list-group" style="display: none;"></ul>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input class="form-control" name="load_consignee_location"
                                                    value="{{ $load->load_consignee_location }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date <code>*</code></label>
                                                <input type="date" class="form-control" name="load_consignee_date"
                                                    id="load_consignee_date" required style="width: 100%;"
                                                    min="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div> -->

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Date And Time<code>*</code></label>
                                                <input class="form-control" type="datetime-local" value="{{ $load->load_consignee_appointment }}" name="load_consignee_appointment" required style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input class="form-control" name="load_consignee_discription"  value="{{ $load->load_consignee_discription }}"style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Commodity Type </label>
                                                <input class="form-control select2" name="load_consignee_type" value="{{ $load->load_consignee_type }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <input class="form-control" name="load_consignee_qty" value="{{ $load->load_consignee_qty }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Weight (lbs)</label>
                                                <input class="form-control" name="load_consignee_weight" value="{{ $load->load_consignee_weight }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Commodity <code>*</code></label>
                                                <input class="form-control" name="load_consignee_commodity" type="text" value="{{ $load->load_consignee_commodity }}" required style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">


                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Value($)<code>*</code></label>
                                                <input class="form-control" name="load_consignee_value" required value="{{ $load->load_consignee_value }}" style="width: 100%;">
                                            </div>
                                        </div>



                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Delivery Notes <code>*</code></label>
                                                <input class="form-control" name="load_consignee_delivery_notes" value="{{ $load->load_consignee_delivery_notes }}" style="width: 100%;">                                            </div>
                                        </div>


                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>P.O Numbers</label>
                                                <input class="form-control" name="load_consignee_po_numbers" value="{{ $load->load_consignee_po_numbers }}" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Pro Miles</label>
                                                <input class="form-control" name="load_consignee_pro_miles" value="{{ $load->load_consignee_pro_miles }}" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Empty</label>
                                                <input class="form-control" name="load_consignee_empty" value="{{ $load->load_consignee_empty }}" style="width: 100%;">
                                            </div>
                                        </div>



                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                <input class="form-control" type="number" name="load_consigneer_contact" value="{{ $load->load_consigneer_contact }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Consignee Notes</label>
                                                <input class="form-control" type="number" name="load_consigneer_notes" value="{{ $load->load_consigneer_notes }}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Comment / Notes</label>
                                                <input class="form-control" type="text" name="comment" value="{{ $load->comment }}" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-info" value="Update Load">
                                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
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

<script>
    // alert('fuck off everone');
    $(document).ready(function () {
        var consigneeCount = 1;

        $('#add_consignee').on('click', function (e) {
            e.preventDefault();

            var newConsigneeSection = $('#consigneeSections .consignee-section:first').clone();

            newConsigneeSection.find('[name^="load_consignee"]').each(function () {
                var currentName = $(this).attr('name');
                $(this).attr('name', currentName.replace('load_consignee', 'load_consignee_' +
                    consigneeCount));
            });

            $('#consigneeSections').append(newConsigneeSection);

            consigneeCount++;
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


<!-- <script>
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
                            html += '<div class="item" data-value="' + carrierName + '">' +
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

        $(document).on('click', '#carrierList .item', function () {
            var selectedCarrier = $(this).text();
            $('#load_carrier').val(selectedCarrier);
            $('#carrierList').html(''); 
        });
    });
</script> -->

<script>
    // Function to populate shipper names as list items
    function populateShipperList(shipperNames, shipperList) {
        shipperList.empty(); // Clear previous list items
        shipperNames.forEach(function (shipperName, index) {
            if (index === 0) {
                shipperList.append('<li class="list-group-item active" style="cursor: pointer;">' +
                    shipperName + '</li>');
            } else {
                shipperList.append('<li class="list-group-item" style="cursor: pointer;">' + shipperName +
                    '</li>');
            }
        });
        shipperList.show(); // Show the list
    }

    // Function to populate carrier names as list items
    function populateCarrierList(carrierNames, carrierList) {
        var html = '';
        carrierNames.forEach(function (carrierName) {
            html += '<div class="item" data-value="' + carrierName + '">' +
                carrierName + '</div>';
        });
        carrierList.html(html);
    }

    // Function to fetch shipper details
    function fetchShipperDetails(query) {
        if (query.trim().length >= 3) {
            $.ajax({
                url: "{{ route('fetch.shipper.details.accounts') }}",
                method: "GET",
                data: {
                    query: query
                },
                dataType: "json",
                success: function (response) {
                    var shipperDetails = response.shipperDetails;
                    var shipperNames = response.shipperNames;
                    var shipperList = $('#shipperList');

                    populateShipperList(shipperNames, shipperList);

                    // Populate location input with first shipper details
                    if (shipperDetails.length > 0) {
                        var shipper = shipperDetails[0]; // Take the first shipper details
                        $('input[name="load_shipper_location"]').val(shipper.shipper_address + ', ' +
                            shipper.shipper_country + ', ' + shipper.shipper_state + ', ' + shipper
                            .shipper_city + ', ' + shipper.shipper_zip);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#shipperList').empty().hide();
            $('input[name="load_shipper_location"]').val(''); // Clear location input
        }
    }

    // Function to fetch carrier names
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
                    var carrierNames = response;
                    var carrierList = $('#carrierList');
                    populateCarrierList(carrierNames, carrierList);
                }
            });
        } else {
            $('#carrierList').html('');
        }
    }

    $(function () {
        // Shipper List
        $(document).on('click', '#shipperList li', function () {
            var selectedShipper = $(this).text();
            $('input[name="load_shipper"]').val(selectedShipper);
            $('#shipperList').hide();
        });

        $('input[name="load_shipper"]').keyup(function () {
            var query = $(this).val();
            fetchShipperDetails(query);
        });

        // Carrier List
        $('#load_carrier').keyup(function () {
            var query = $(this).val();
            fetchCarrierNames(query);
        });

        $(document).on('click', '#carrierList .item', function () {
            var selectedCarrier = $(this).text();
            $('#load_carrier').val(selectedCarrier);
            $('#carrierList').html(''); // Clear the list
        });
    });
</script>



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
                        if (response.trim() === '') {
                            $('#load_carrier').val('No data found in database');
                        } else {
                            $('#load_carrier').val(response);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error if needed
                    }
                });
            } else {
                $('#load_carrier').val('');
            }
        });
    });
</script>


<script>
    $(function () {
        function fetchCustomerNames(query) {
            if (query.trim().length >= 3) { // Check if the query length is at least three characters
                $.ajax({
                    url: "{{ route('fetch.customer.details.accounts') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    dataType: "json",
                    success: function (response) {
                        var customerNames = response.join(
                            '\n'); // Join the array of customer names with line breaks
                        $('#customerList').val(customerNames); // Set the textarea content
                        $('#customerList').show(); // Show the textarea
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('#customerList').val(
                    ''); // Clear the content of the textarea if query length is less than three
                $('#customerList').hide(); // Hide the textarea
            }
        }

        // Handle click event on customer names inside the textarea
        $(document).on('click', '#customerList', function () {
            var selectedCustomer = $(this).val();
            $('#load_bill_to').val(selectedCustomer); // Fill the input with the selected customer name
            $('#customerList').hide(); // Hide the textarea after selection
        });

        $('#load_bill_to').keyup(function () {
            var query = $(this).val();
            fetchCustomerNames(query);
        });
    });
</script>



<script>
    function fetchShipperDetails(query) {
        if (query.trim().length >= 3) {
            $.ajax({
                url: "{{ route('fetch.shipper.details.accounts') }}",
                method: "GET",
                data: {
                    query: query
                },
                dataType: "json",
                success: function (response) {
                    var shipperDetails = response.shipperDetails;
                    var shipperNames = response.shipperNames;
                    var shipperList = $('#shipperList');

                    // Clear previous list items
                    shipperList.empty();

                    // Populate shipper names as list items
                    shipperNames.forEach(function (shipperName) {
                        shipperList.append('<li class="list-group-item">' + shipperName + '</li>');
                    });

                    shipperList.show();

                    // Populate location input with first shipper details
                    if (shipperDetails.length > 0) {
                        var shipper = shipperDetails[0]; // Take the first shipper details
                        $('input[name="load_shipper_location"]').val(shipper.shipper_address + ', ' +
                            shipper.shipper_country + ', ' + shipper.shipper_state + ', ' + shipper
                            .shipper_city + ', ' + shipper.shipper_zip);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#shipperList').empty().hide();
            $('input[name="load_shipper_location"]').val(''); // Clear location input
        }
    }

    $(document).on('click', '#shipperList li', function () {
        var selectedShipper = $(this).text();
        $('input[name="load_shipper"]').val(selectedShipper);
        $('#shipperList').hide();
    });

    $('input[name="load_shipper"]').keyup(function () {
        var query = $(this).val();
        fetchShipperDetails(query);
    });
</script>

<script>
    // Populate shipper names as list items
    shipperNames.forEach(function (shipperName, index) {
        if (index === 0) {
            shipperList.append('<li class="list-group-item active" style="cursor: pointer;">' + shipperName +
                '</li>');
        } else {
            shipperList.append('<li class="list-group-item" style="cursor: pointer;">' + shipperName + '</li>');
        }
    });
</script>




<script>
    function fetchConsigneeDetails(query) {
        if (query.trim().length >= 1) {
            $.ajax({
                url: "{{ route('fetch.consignee.details.account') }}",
                method: "GET",
                data: {
                    query: query
                },
                dataType: "json",
                success: function (response) {
                    var consigneeNames = response;

                    // Clear previous list items
                    $('#consigneeList').empty();

                    // Populate consignee names as list items
                    consigneeNames.forEach(function(consigneeName, index) {
                        if (index === 0) {
                            $('#consigneeList').append('<li class="list-group-item active" style="cursor: pointer;">' + consigneeName + '</li>');
                        } else {
                            $('#consigneeList').append('<li class="list-group-item" style="cursor: pointer;">' + consigneeName + '</li>');
                        }
                    });

                    $('#consigneeList').show();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#consigneeList').empty().hide();
            $('input[name="load_consignee_location"]').val(''); // Clear location input
        }
    }

    // Handle click event on consignee list items
    $(document).on('click', '#consigneeList li', function () {
        var selectedConsignee = $(this).text();
        $('input[name="load_consignee"]').val(selectedConsignee);
        $('#consigneeList').hide();
    });

    // Listen for keyup event on consignee input
    $('input[name="load_consignee"]').keyup(function () {
        var query = $(this).val();
        fetchConsigneeDetails(query);
    });
</script>




@endsection