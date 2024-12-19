@extends('layouts.admin.app')
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
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
           <h2><b>Basic Form Elements</b></h2>
        </div>

        <div class="container-fluid p-0">
            <!-- Input -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">

                    <div class="card">
                        <div class="body">
                            <form action="{{ route('loads.update', $load->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h3 class="card-title">Update Load</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Load Number <code>*</code></label>
                                                @if($load)
                                                <input class="form-control" name="load_number" disabled
                                                    style="width: 100%;" value="{{ $load->id }}">
                                                @else
                                                <p>No load found with the specified ID.</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Bill To <code>*</code>&nbsp;<a href="{{ url('/customer') }}"
                                                        id="bill_to_add_request" style="color:#0c7ce6"><i
                                                            class="fa fa-plus"></i>Add New</a> </label>
                                                @if($load)
                                                <input class="form-control" name="load_bill_to" required
                                                    style="width: 100%;" value="{{ $load->load_bill_to }}">
                                                @else
                                                <p>No load found with the Bill To </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Dispatcher <code>*</code></label>
                                                @if($load)
                                                <input class="form-control" name="load_dispatcher"
                                                    value="{{ $load->load_dispatcher }}" required readonly
                                                    style="width: 100%;">
                                                @else
                                                <p>No load found with the Bill To </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control select2" name="load_status"
                                                    value="{{ $load->load_status }}" style="width: 100%;">
                                                    @if($load)
                                                    <option selected="selected" value="{{ $load->load_status }}">
                                                        {{ $load->load_status }}</option>
                                                    <option>Open</option>
                                                    <option>Covered</option>
                                                    <option>Dispatched</option>
                                                    <option>Loading</option>
                                                    <option>On Route</option>
                                                    <option>Un loading</option>
                                                    <option>Deliverd</option>
                                                    @else
                                                    <p>No load found with the Bill To </p>
                                                    @endif
                                                    <!-- <option>In yard</option>
                                            <option>Deliverd</option>
                                            <option>Completed</option> -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Work Order </label>
                                                @if($load)
                                                <input class="form-control" name="load_workorder"
                                                    value="{{ $load->load_workorder }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Bill To </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Payment Type <code>*</code></label>
                                                <select class="form-control select2" required name="load_payment_type"
                                                    style="width: 100%;">
                                                    @if($load)
                                                    <option selected="selected">{{ $load->load_payment_type }}</option>
                                                    <option>Prepaid</option>
                                                    <option>Postpaid</option>
                                                    @else
                                                    <p>No load found with the Bill To </p>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Type <code>*</code></label>
                                                @if($load)
                                                <input class="form-control" required name="load_type"
                                                    value="{{ $load->load_type }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Bill To </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipper Rate <code>*</code></label>
                                                @if($load)
                                                <input type="number" class="form-control number value"
                                                    name="load_shipper_rate" id="load_shipper_rate" required
                                                    style="width: 100%;" value="{{ $load->load_shipper_rate }}">
                                                @else
                                                <p>No load found with the Bill To </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>P/D s</label>
                                                @if($load)
                                                <input class="form-control" name="load_pds" type="number"
                                                    value="{{ $load->load_pds }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Bill To </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>F.S.C Rate % <input hidden type="checkbox"
                                                        name="calculate_fsc_percentage"
                                                        id="calculate_fsc_percentage"></label>
                                                @if($load)
                                                <input class="form-control number percent" name="load_fsc_rate"
                                                    id="load_fsc_rate" value="{{ $load->load_fsc_rate }}"
                                                    style="width: 100%;">
                                                @else
                                                <p>No load found with the Bill To </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Telephone <code>*</code></label>
                                                @if($load)
                                                <input class="form-control" name="load_telephone"
                                                    value="{{ $load->load_telephone }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Bill To </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="other_charge">Other Change &nbsp; <i class="fa fa-plus"
                                                        data-toggle="modal" data-target="#myModal"
                                                        id="load_shipper_other_charges"></i></label>
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
                                                                            @if($load)
                                                                            @if($load->shipperchargeType)
                                                                            @foreach($load->shipperchargeType as $chargeType)
                                                                            <input type="text" class="form-control"
                                                                                name="shipperchargeType[]"
                                                                                value="{{ $chargeType }}"
                                                                                placeholder="Enter charge type">
                                                                            @endforeach
                                                                            @else
                                                                            <p>No charge types found for the load.</p>
                                                                            @endif
                                                                            @else
                                                                            <p>No load found with the specified
                                                                                conditions.</p>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Charge Amount:</label>
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
                                                                id="addChargeBtn">Add Charge</button>
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
                                                @if($load)
                                                <input class="form-control result" disabled
                                                    name="shipper_load_final_rate" id="shipper_load_final_rate"
                                                    value="{{ $load->shipper_load_final_rate }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the specified conditions.</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier <code>*</code></label>
                                                @if($load)
                                                <input class="form-control" required name="load_carrier"
                                                    value="{{ $load->load_carrier }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the specified conditions.</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Advance Payment</label>
                                                @if($load)
                                                <input class="form-control" name="load_advance_payment"
                                                    value="{{ $load->load_advance_payment }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the specified conditions.</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Load type</label>
                                                <div class="select2-purple">
                                                    <select class="form-control select2" name="load_type_two"
                                                        style="width: 100%;">
                                                        @if($load)
                                                        <option selected="selected">{{ $load->load_type_two }}</option>
                                                        <option>OTR</option>
                                                        <option>DRAYAGE</option>
                                                        @else
                                                        <p>No load found with the specified conditions.</p>
                                                        @endif
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
                                                    @if($load)
                                                    <option selected="selected">{{ $load->load_billing_type }}</option>
                                                    <option>Factoring</option>
                                                    <option>Direct Billing</option>
                                                    @else
                                                    <p>No load found with the specified conditions.</p>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>MC No <code>*</code></label>
                                                @if($load)
                                                <input class="form-control" required name="load_mc_no"
                                                    value="{{ $load->load_mc_no }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the specified conditions.</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Equipment Type <code>*</code></label>
                                                <select class="form-control select2" required name="load_equipment_type"
                                                    style="width: 100%;">
                                                    @if($load)
                                                    <option selected="selected">{{ $load->load_equipment_type }}
                                                    </option>
                                                    <option value="22' VAN">22' VAN</option>
                                                    <option value="48' Reefer">48' Reefer</option>
                                                    <option value="53' Reefer">53' Reefer</option>
                                                    <option value="53' VAN">53' VAN</option>
                                                    <option value="Air Freight">Air Freight</option>
                                                    <option value="Anhydros Ammonia">Anhydros Ammonia</option>
                                                    <option value="Animal Carrier">Animal Carrier</option>
                                                    <option value="Any Equipment">Any Equipment</option>
                                                    <option value="Searching Services only">Any Equipment (Searching
                                                        Services only)</option>
                                                    <option value="Auto Carrier">Auto Carrier</option>
                                                    <option value="B-Train/Supertrain">B-Train/Supertrain</option>
                                                    <option value="Canada Only">B-Train/Supertrain (Canada Only)
                                                    </option>
                                                    <option value="Beam">Beam</option>
                                                    <option value="Belly Dump">Belly Dump</option>
                                                    <option value="Blanket Wrap Van">Blanket Wrap Van</option>
                                                    <option value="Boat Hauling Trailer">Boat Hauling Trailer</option>
                                                    <option value="Cargo Van (1 Ton)">Cargo Van (1 Ton)</option>
                                                    <option value="Cargo Vans (1 Ton capacity)">Cargo Vans (1 Ton
                                                        capacity)</option>
                                                    <option value="Cargo/Small/Sprinter Van">Cargo/Small/Sprinter Van
                                                    </option>
                                                    <option value="Conestoga">Conestoga</option>
                                                    <option value="Container Trailer">Container Trailer</option>
                                                    <option value="Convertible Hopper">Convertible Hopper</option>
                                                    <option value="Conveyor Belt">Conveyor Belt </option>
                                                    <option value="Crane Truck">Crane Truck</option>
                                                    <option value="Curtain Siders">Curtain Siders </option>
                                                    <option value="Curtain Van">Curtain Van</option>
                                                    <option value="Double Drop">Double Drop</option>
                                                    <option value="Double Drop Extendable">Double Drop Extendable
                                                    </option>
                                                    <option value="Drive Away">Drive Away</option>
                                                    <option value="Dump Trucks">Dump Trucks</option>
                                                    <option value="End Dump">End Dump</option>
                                                    <option value="Flat Intermodal">Flat Intermodal</option>
                                                    <option value="Flat with Traps">Flat with Traps</option>
                                                    <option value="FlatBed">FlatBed</option>
                                                    <option value="FlatBed - Air-ride">FlatBed - Air-ride</option>
                                                    <option value="Flatbed Blanket Wrapped">Flatbed Blanket Wrapped
                                                    </option>
                                                    <option value="Flatbed Intermodal">Flatbed Intermodal</option>
                                                    <option value="Flatbed or Step Deck">Flatbed or Step Deck</option>
                                                    <option value="Flatbed or Van">Flatbed or Van </option>
                                                    <option value="Flatbed or Vented Van">Flatbed or Vented Van</option>
                                                    <option value="Flatbed Over-Dimension Loads">Flatbed Over-Dimension
                                                        Loads</option>
                                                    <option value="Flatbed With Sides">Flatbed With Sides</option>
                                                    <option value="Flatbed, Step Deck or Van">Flatbed, Step Deck or Van
                                                    </option>
                                                    <option value="Flatbed, Van or Reefer">Flatbed, Van or Reefer
                                                    </option>
                                                    <option value="Flatbed, Vented Van or Reefer">Flatbed, Vented Van or
                                                        Reefer</option>
                                                    <option value="Haul and Tow Unit">Haul and Tow Unit</option>
                                                    <option value="Hazardous Material Load">Hazardous Material Load
                                                    </option>
                                                    <option value="Hopper Bottom">Hopper Bottom</option>
                                                    <option value="Hot Shot">Hot Shot</option>
                                                    <option value="Labour">Labour</option>
                                                    <option value="Landoll Flatbed">Landoll Flatbed</option>
                                                    <option value="Live Bottom Trailer">Live Bottom Trailer</option>
                                                    <option value="Load-Out">Load-Out</option>
                                                    <option value="Load-Out are empty trailers you load and haul">
                                                        Load-Out are empty trailers you load and haul</option>
                                                    <option value="Lowboy">Lowboy</option>
                                                    <option value="Lowboy Over-Dimension Loads">Lowboy Over-Dimension
                                                        Loads</option>
                                                    <option value="Maxi or Double Flat Trailers">Maxi or Double Flat
                                                        Trailers</option>
                                                    <option value="Mobile Home">Mobile Home</option>
                                                    <option value="Moving Van">Moving Van</option>
                                                    <option value="Multi-Axle Heavy Hauler">Multi-Axle Heavy Hauler
                                                    </option>
                                                    <option value="Ocean Freight">Ocean Freight</option>
                                                    <option value="Open Top">Open Top</option>
                                                    <option value="Open Top Van">Open Top Van</option>
                                                    <option value="Pneumatic">Pneumatic</option>
                                                    <option value="Power Only">Power Only</option>
                                                    <option value="Power Only (Tow-Away)">Power Only (Tow-Away)</option>
                                                    <option value="Rail">Rail</option>
                                                    <option value="Reefer Pallet Exchange">Reefer Pallet Exchange
                                                    </option>
                                                    <option value="Refrigerated (Reefer)">Refrigerated (Reefer)</option>
                                                    <option value="Refrigerated Carrier with Plant Decking">Refrigerated
                                                        Carrier with Plant Decking</option>
                                                    <option value="Refrigerated Intermodal">Refrigerated Intermodal
                                                    </option>
                                                    <option value="Removable Goose Neck">Removable Goose Neck</option>
                                                    <option value="Multi-Axle Heavy Haulers">Removable Goose Neck
                                                        &amp;Multi-Axle Heavy Haulers</option>
                                                    <option value="GN Extendable">RGN Extendable</option>
                                                    <option value="Roll Top Conestoga">Roll Top Conestoga</option>
                                                    <option value="Roller Bed">Roller Bed</option>
                                                    <option value="Specialized Trailers">Specialized Trailers</option>
                                                    <option value="Step Deck">Step Deck</option>
                                                    <option value="Step Deck Conestoga">Step Deck Conestoga</option>
                                                    <option value="Step Deck Extendable">Step Deck Extendable</option>
                                                    <option value="Step Deck or Flat">Step Deck or Flat</option>
                                                    <option value="Step Deck or Removable Gooseneck">Step Deck or
                                                        Removable Gooseneck</option>
                                                    <option value="Step Deck Over-Dimension Loads">Step Deck
                                                        Over-Dimension Loads</option>
                                                    <option value="Step Deck with Loading Ramps">Step Deck with Loading
                                                        Ramps</option>
                                                    <option value="Straight Van">Straight Van </option>
                                                    <option value="Stretch Trailer or Ext. Flat">Stretch Trailer or Ext.
                                                        Flat </option>
                                                    <option value="Stretch Trailer or Extendable Flatbed">Stretch
                                                        Trailer or Extendable Flatbed</option>
                                                    <option value="Supplies">Supplies</option>
                                                    <option value="Tandem Van">Tandem Van</option>
                                                    <option value="Tanker">Tanker</option>
                                                    <option value="Tanker (Food grade, liquid, bulk, etc.)">Tanker (Food
                                                        grade, liquid, bulk, etc.)</option>
                                                    <option value="Team Driver Needed">Team Driver Needed</option>
                                                    <option value="Tridem">Tridem</option>
                                                    <option value="Two 24 or 28 Foot Flatbeds">Two 24 or 28 Foot
                                                        Flatbeds </option>
                                                    <option value="Unspecified Specialized Trailers">Unspecified
                                                        Specialized Trailers</option>
                                                    <option value="Van">Van</option>
                                                    <option value="Van - Air-Ride">Van - Air-Ride</option>
                                                    <option value="Van Intermodal">Van Intermodal</option>
                                                    <option value="Van or Flatbed">Van or Flatbed</option>
                                                    <option value="Van or Reefer">Van or Reefer</option>
                                                    <option value="Van Pallet Exchange">Van Pallet Exchange</option>
                                                    <option value="Van with Liftgate">Van with Liftgate</option>
                                                    <option value="Van, Reefer or Double Drop">Van, Reefer or Double
                                                        Drop</option>
                                                    <option value="Vented Insulated Van">Vented Insulated Van</option>
                                                    <option value="Vented Insulated Van or Refrigerated">Vented
                                                        Insulated Van or Refrigerated</option>
                                                    <option value="Vented Van">Vented Van</option>
                                                    <option value="Vented Van or Refrigerated">Vented Van or
                                                        Refrigerated</option>
                                                    <option value="Walking Floor">Walking Floor </option>
                                                    <option value="BOX Truck">BOX Truck</option>
                                                    <option value="Reefer Container">Reefer Container</option>
                                                    <option value="Tandem">Tandem</option>
                                                    <option value="B Train">B Train</option>
                                                    <option value="Flatbed with Tarps">Flatbed with Tarps</option>
                                                    <option value="Flatbed with straps">Flatbed with straps</option>
                                                    @else
                                                    <p>No load found with the specified conditions.</p>
                                                    @endif

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier Fee <code>*</code></label>
                                                @if($load)
                                                <input class="form-control" type="number" name="load_carrier_fee"
                                                    id="load_carrier_fee" value="{{ $load->load_carrier_fee }}" required
                                                    style="width: 100%;">
                                                @else
                                                <p>No load found with the specified conditions.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select class="form-control select2" name="load_currency"
                                                    style="width: 100%;">
                                                    @if($load)
                                                    <option selected="selected">{{ $load->load_currency }}</option>
                                                    <option>$</option>
                                                    <option>%</option>
                                                    @else
                                                    <option>No load found with the Currency</option>

                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>P/D s <code>*</code></label>
                                                @if($load)
                                                <input class="form-control" name="load_pds_two"
                                                    value="{{ $load->load_pds_two }}" required style="width: 100%;">
                                                @else
                                                <p>No load found with the P/D s</p>

                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>FSC Rate %</label>
                                                @if($load)
                                                <input type="text" name="load_billing_fsc_rate"
                                                    id="load_billing_fsc_rate" class="form-control"
                                                    value="{{ $load->load_billing_fsc_rate }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the P/D s</p>

                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="other_charge">Other Charges <i class="fa fa-plus"
                                                        id="openModalIcon"></i></label>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="otherChargesModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" id="model_content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Other Charges
                                                            </h5>
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
                                                                            @if($load)
                                                                            <input type="text"
                                                                                class="form-control typeofcharge"
                                                                                placeholder="Please enter type of charges"
                                                                                value="{{ $load->inputBox1 ?? '' }}"
                                                                                name="inputBox1[]">
                                                                            @else
                                                                            <p>No load found with the Other Charges</p>
                                                                            @endif
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
                                                @if($load)
                                                <input class="form-control" readonly name="load_final_carrier_fee"
                                                    id="load_final_carrier_fee"
                                                    value="{{ $load->load_final_carrier_fee }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Final Carrier Fee</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label>Dilevery Order</label>
                                                @if($load)
                                                <input class="form-control" type="file" readonly
                                                    name="load_delivery_do_file" id="load_delivery_do_file"
                                                    value="{{ $load->load_delivery_do_file }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Final Carrier Fee</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label>Rate Coin</label>
                                                @if($load)
                                                <input class="form-control" type="file" readonly
                                                    name="load_rate_coin_file" id="load_rate_coin_file"
                                                    value="{{$load->load_rate_coin_file}}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Final Carrier Fee</p>
                                                @endif
                                            </div>
                                        </div>

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
                                                @if($load)
                                                <input class="form-control" name="load_shipperr" required
                                                    value="{{ $load->load_shipperr }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Final Carrier Fee</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Location</label>
                                                @if($load)
                                                <input class="form-control" name="load_shipper_location"
                                                    value="{{ $load->load_shipper_location }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date <code>*</code></label>
                                                @if($load && isset($load->load_shipper_date))
                                                <input type="text" class="form-control" name="load_shipper_date"
                                                    value="{{$load->load_shipper_date}}" required style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                @if($load)
                                                <label>Description</label>
                                                <input class="form-control" name="load_shipper_discription"
                                                    value="{{ $load->load_shipper_discription }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Commodity Type</label>
                                                @if($load)
                                                <input class="form-control select2" name="load_shipper_commodity_type"
                                                    value="{{ $load->load_shipper_commodity_type }}"
                                                    style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                @if($load)
                                                <input class="form-control" name="load_shipper_qty"
                                                    value="{{ $load->load_shipper_qty}}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Weight (lbs)</label>
                                                @if($load)
                                                <input class="form-control" name="load_shipper_weight"
                                                    value="{{ $load->load_shipper_weight }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Commodity <code>*</code></label>
                                                @if($load)
                                                <input class="form-control" name="load_shipper_commodity" type="text"
                                                    value="{{ $load->load_shipper_commodity }}" required
                                                    style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Value($)<code>*</code></label>
                                                @if($load)
                                                <input class="form-control" name="load_shipper_value" required
                                                    value="{{ $load->load_shipper_value }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Shipping Notes</label> <!-- Corrected the label tag -->
                                                @if($load)
                                                <input class="form-control" name="load_shipper_shipping_notes"
                                                    value="{{ $load->load_shipper_shipping_notes }}"
                                                    style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>P.O Numbers</label>
                                                @if($load)
                                                <input class="form-control" name="load_shipper_po_numbers" value="{{ $load->load_shipper_po_numbers }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                @if($load)
                                                <input class="form-control" type="number" name="load_shipper_contact" value="{{ $load->load_shipper_contact }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">


                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label>Appointment<code>*</code></label>
                                            @if($load)
                                            <input class="form-control" type="text" name="load_shipper_appointment" value="{{ $load->load_shipper_appointment }}" required style="width: 100%;">
                                            @else
                                                <p>No load found with the Location</p>    
                                            @endif
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
                                        <label>Consignee <code>*</code> <a href="{{ url('/consignee') }}">Add New</a></label>
                                        @if($load)
                                        <input class="form-control" name="load_consignee" value="{{ $load->load_consignee }}" required style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Location</label>
                                        @if($load)
                                        <input class="form-control" name="load_consignee_location" value="{{ $load->load_consignee_location }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date <code>*</code></label>
                                        @if($load)
                                        <input type="text" class="form-control" name="load_consignee_date" required value="{{ $load->load_consignee_date }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Description</label>
                                        @if($load)
                                        <input class="form-control" name="load_consignee_discription" value="{{ $load->load_consignee_discription }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Commodity Type </label>
                                        @if($load)
                                        <input class="form-control select2" name="load_consignee_discription" value="{{ $load->load_consignee_discription }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Qty</label>
                                        @if($load)
                                        <input class="form-control" name="load_consignee_qty" value="{{ $load->load_consignee_qty }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Weight (lbs)</label>
                                        @if($load)
                                        <input class="form-control" name="load_consignee_weight" value="{{ $load->load_consignee_weight }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>Commodity <code>*</code></label>.
                                        @if($load)
                                        <input class="form-control" name="load_consignee_commodity" type="text" value="{{ $load->load_consignee_commodity }}" required style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>Value($)<code>*</code></label>
                                        @if($load)
                                        <input class="form-control" name="load_consignee_value" value="{{ $load->load_consignee_value }}" required style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>Delivery Notes </label>
                                        @if($load)
                                                <input class="form-control" name="load_consignee_delivery_notes" value="{{ $load->load_consignee_delivery_notes }}" style="width: 100%;">
                                                @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>P.O Numbers</label>
                                        @if($load)
                                        <input class="form-control" name="load_consignee_po_numbers" value="{{ $load->load_consignee_po_numbers }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Pro Miles</label>
                                        @if($load)
                                        <input class="form-control" name="load_consignee_pro_miles" value="{{ $load->load_consignee_pro_miles }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Empty</label>
                                        @if($load)
                                        <input class="form-control" name="load_consignee_empty" value="{{ $load->load_consignee_empty }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>Appointment<code>*</code></label>
                                        @if($load)
                                        <input class="form-control" type="text" name="load_consignee_appointment" value="{{ $load->load_consignee_appointment }}" required style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>Contact</label>
                                        @if($load)
                                        <input class="form-control" type="number" name="load_consigneer_contact" value="{{ $load->load_consigneer_contact }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>Consignee Notes</label>
                                        @if($load)
                                        <input class="form-control" type="number"  name="load_consigneer_notes" value="{{ $load->load_consigneer_notes }}" style="width: 100%;">
                                        @else
                                                <p>No load found with the Location</p>    
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Load</button>
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

@endsection
