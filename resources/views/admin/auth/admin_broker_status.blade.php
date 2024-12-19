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
<style>
     .table>:not(caption)>*>* {
        background-color: unset !important;
    }
        table.dataTable thead>tr>th.sorting_asc,
    table.dataTable thead>tr>th.sorting_desc,
    table.dataTable thead>tr>th.sorting,
    table.dataTable thead>tr>td.sorting_asc,
    table.dataTable thead>tr>td.sorting_desc,
    table.dataTable thead>tr>td.sorting {
        padding: 13px 6px 13px 6px;
    font-size: 13px;
    text-align: center;
    background-image: unset !important;
    }
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important">
                    <h2><b>Account Manager</b></h2>
        </div>

        <div class="container-fluid p-0">
            <!-- Tab buttons -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"
                        aria-controls="all" aria-selected="true" style="font-size: 15px;color: #000;font-weight:500">All Loads Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="delivered-tab" data-bs-toggle="tab" href="#delivered" role="tab"
                        aria-controls="delivered" aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Delivered</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="completed-tab" data-bs-toggle="tab" href="#completed" role="tab"
                        aria-controls="completed" aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Completed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="invoiced-tab" data-bs-toggle="tab" href="#invoiced" role="tab"
                        aria-controls="invoiced" aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Invoiced</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="paid-tab" data-bs-toggle="tab" href="#paid" role="tab" aria-controls="paid"
                        aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Invoice / Paid</a>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="delivered-tab">
                    <div class="load-search mb-2">
                        <input type="text" class="form-control" id="loadNumberSearch" placeholder="Search Load #" style="width: 12%;">
                    </div>
                        <!-- Delivered data table -->
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable no-footer display load_number" data-page-length="50">
                                <thead>
                                    <tr>
                                        <th style="color: #fff !important;">Sr No</th>
                                        <th style="color: #fff !important;">Load #</th>
                                        <th style="color: #fff !important;">W/O #</th>
                                        <th style="color: #fff !important;">Customer Name</th>
                                        <th style="color: #fff !important;">Invoice #</th>
                                        <th style="color: #fff !important;">Invoice Date</th>
                                        <th style="color: #fff !important;">Agent</th>
                                        <th style="color: #fff !important;">Office</th>
                                        <th style="color: #fff !important;">Team Leader</th>
                                        <th style="color: #fff !important;">Manager</th>
                                        <th style="color: #fff !important;">Load Creation Date</th>
                                        <th style="color: #fff !important;">Shipper Date</th>
                                        <th style="color: #fff !important;">Delivered Date</th>
                                        <th style="color: #fff !important;">Actual Del Date</th>
                                        <th style="color: #fff !important;">Carrier</th>
                                        <th style="color: #fff !important;">Pickup Location</th>
                                        <th style="color: #fff !important;">Unloading Location</th>
                                        <th style="color: #fff !important;">Load Status</th>
                                        <th style="color: #fff !important;">Margin</th>
                                        <th style="color: #fff !important;">Aging</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach($status as $s)
                                    <tr>
                                        <td class="dynamic-data">{{ $i++ }}</td>
                                        <td class="dynamic-data" id="load_number">
                                              <a style="color: rgb(10 185 90) !important;font-weight: 700;cursor:pointer" onclick="openUploadWindow('{{ route('admin.load.edit', $s->id) }}')">{{ $s->load_number }}</a>
                                        </td>
                                        <td class="dynamic-data">{{ $s->load_workorder }}</td>
                                        <td class="dynamic-data">{{ $s->load_bill_to }}</td>
                                        <td class="dynamic-data">{{ $s->invoice_number }}</td>
                                        <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') }}</td>
                                        <td class="dynamic-data">{{ $s->user->name }}</td>
                                        <td class="dynamic-data">{{ $s->user->office }}</td>
                                        <td class="dynamic-data">{{ $s->user->team_lead }}</td>
                                        <td class="dynamic-data">{{ $s->user->manager }}</td>
                                        <td class="dynamic-data">{{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment, true);
                                        @endphp
                                        <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                        $consignee_appointment = json_decode($s->load_consignee_appointment, true);
                                        @endphp
                                        <td class="dynamic-data">
                                            {{ isset($consignee_appointment[0]['appointment']) && strtotime($consignee_appointment[0]['appointment']) 
                                                ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                                : '' }}
                                        </td>
                                        <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}</td>
                                        <td class="dynamic-data">{{ $s->load_carrier }}</td>
                                        @php
                                        $shipper_location = json_decode($s->load_shipper_location, true);
                                        @endphp
                                        <td class="dynamic-data">
                                            {{ $shipper_location[0]['location'] ?? '' }}
                                        </td>
                                        @php
                                        $consignee_location = json_decode($s->load_consignee_location, true);
                                        @endphp
                                        <td class="dynamic-data">
                                            {{ $consignee_location[0]['location'] ?? '' }}
                                        </td>
                                        <td class="dynamic-data">{{ $s->load_status }}</td>
                                        @php
                                        $shipperRate = floatval($s->shipper_load_final_rate);
                                        $carrierFee = floatval($s->load_final_carrier_fee);
                                        $getMargin = $shipperRate - $carrierFee;
                                        @endphp
                                        <td class="dynamic-data" style="color:green;">${{ number_format($getMargin, 2) }}</td>
                                        <td class="dynamic-data">
                                            @if($s->load_status == 'Delivered' || $s->invoice_status == 'Completed' )
                                            @php
                                            $deliveredDate = \Carbon\Carbon::parse($s->created_at);
                                            $currentDate = \Carbon\Carbon::now();
                                            $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                            @endphp
                                            {{ $differenceInDays }} days
                                            @elseif($s->invoice_status == 'Completed' || $s->load_status == 'Delivered')
                                            Aging Complete
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
                <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                
                    <!-- Delivered data table -->
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable no-footer">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Sr No</th>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Invoice #</th>
                                    <th style="color: #fff !important;">Invoice Date</th>
                                    <th style="color: #fff !important;">Agent</th>
                                    <th style="color: #fff !important;">Office</th>
                                    <th style="color: #fff !important;">Team Leader</th>
                                    <th style="color: #fff !important;">Manager</th>
                                    <th style="color: #fff !important;">Load Creation Date</th>
                                    <th style="color: #fff !important;">Shipper Date</th>
                                    <th style="color: #fff !important;">Delivered Date</th>
                                    <th style="color: #fff !important;">Actual Del Date</th>
                                    <th style="color: #fff !important;">Carrier</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                    <th style="color: #fff !important;">Margin</th>
                                    <th style="color: #fff !important;">Aging</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($status as $s)
                                @if($s->load_status == 'Delivered')
                                <tr>
                                    <td class="dynamic-data">{{ $i++ }}</td>
                                    <td class="dynamic-data">{{ $s->load_number }}</td>
                                    <td class="dynamic-data">{{ $s->load_workorder }}</td>
                                    <td class="dynamic-data">{{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data">{{ $s->invoice_number }}</td>
                                    <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') }}</td>
                                    <td class="dynamic-data">{{ $s->user->name }}</td>
                                    <td class="dynamic-data">{{ $s->user->office }}</td>
                                    <td class="dynamic-data">{{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data">{{ $s->user->manager }}</td>
                                    <td class="dynamic-data">{{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                    <td class="dynamic-data"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}</td>
                                    <td class="dynamic-data">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}
                                    </td>
                                    <td class="dynamic-data">
                                        {{ $s->load_status }}
                                    </td>
                                        @php
                                        $shipperRate = floatval($s->shipper_load_final_rate);
                                        $carrierFee = floatval($s->load_final_carrier_fee);
                                        $getMargin = $shipperRate - $carrierFee;
                                         @endphp
                                    <td class="dynamic-data" style="color:green;">${{ number_format($getMargin, 2) }}</td>
                                    <td class="dynamic-data">
                                        @if($s->load_status == 'Delivered' ||
                                        $s->invoice_status == 'Completed' )
                                        @php
                                        $deliveredDate = \Carbon\Carbon::parse($s->created_at);
                                        $currentDate = \Carbon\Carbon::now();
                                        $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                        @endphp
                                        {{ $differenceInDays }} days
                                        @elseif($s->invoice_status == 'Completed' ||
                                        $s->load_status == 'Delivered')
                                        Aging Complete
                                        @endif
                                    </td>


                                    <!-- <td><button class="btn btn-sm btn-danger">Delete</button></td> -->
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                
                    <!-- Completed data table -->
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable no-footer">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Sr No</th>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Invoice #</th>
                                    <th style="color: #fff !important;">Invoice Date</th>
                                    <th style="color: #fff !important;">Agent</th>
                                    <th style="color: #fff !important;">Office</th>
                                    <th style="color: #fff !important;">Team Leader</th>
                                    <th style="color: #fff !important;">Manager</th>
                                    <th style="color: #fff !important;">Load Creation Date</th>
                                    <th style="color: #fff !important;">Shipper Date</th>
                                    <th style="color: #fff !important;">Delivered Date</th>
                                    <th style="color: #fff !important;">Actual Del Date</th>
                                    <th style="color: #fff !important;">Carrier</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Margin</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($status as $s)
                                @if($s->load_status == 'Completed')
                                <tr>
                                    <td class="dynamic-data">{{ $i++ }}</td>
                                    <td class="dynamic-data">{{ $s->load_number }}</td>
                                    <td class="dynamic-data">{{ $s->load_workorder }}</td>
                                    <td class="dynamic-data">{{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data">{{ $s->invoice_number }}</td>
                                    <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') }}</td>
                                    <td class="dynamic-data">{{ $s->user->name }}</td>
                                    <td class="dynamic-data">{{ $s->user->office }}</td>
                                    <td class="dynamic-data">{{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data">{{ $s->user->manager }}</td>
                                    <td class="dynamic-data">{{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                    <td class="dynamic-data"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}</td>
                                    <td class="dynamic-data">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $shipperRate = floatval($s->shipper_load_final_rate);
                                        $carrierFee = floatval($s->load_final_carrier_fee);
                                        $getMargin = $shipperRate - $carrierFee;
                                    @endphp
                                    <td class="dynamic-data" style="color:green;">${{ number_format($getMargin, 2) }}</td>
                                    <td class="dynamic-data">
                                        {{ $s->load_status }}
                                    </td>
                                    <!-- <td><button class="btn btn-sm btn-danger">Delete</button></td> -->
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="invoiced" role="tabpanel" aria-labelledby="invoiced-tab">
                
                    <!-- Invoiced data table -->
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable no-footer">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Sr No</th>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Invoice #</th>
                                    <th style="color: #fff !important;">Invoice Date</th>
                                    <th style="color: #fff !important;">Agent</th>
                                    <th style="color: #fff !important;">Office</th>
                                    <th style="color: #fff !important;">Team Leader</th>
                                    <th style="color: #fff !important;">Manager</th>
                                    <th style="color: #fff !important;">Load Creation Date</th>
                                    <th style="color: #fff !important;">Shipper Date</th>
                                    <th style="color: #fff !important;">Delivered Date</th>
                                    <th style="color: #fff !important;">Actual Del Date</th>
                                    <th style="color: #fff !important;">Carrier</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Margin</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($status as $s)
                                @if($s->invoice_status == 'Paid')
                                <tr>
                                    <td class="dynamic-data">{{ $i++ }}</td>
                                    <td class="dynamic-data">{{ $s->load_number }}</td>
                                    <td class="dynamic-data">{{ $s->load_workorder }}</td>
                                    <td class="dynamic-data">{{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data">{{ $s->invoice_number }}</td>
                                    <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') }}</td>
                                    <td class="dynamic-data">{{ $s->user->name }}</td>
                                    <td class="dynamic-data">{{ $s->user->office }}</td>
                                    <td class="dynamic-data">{{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data">{{ $s->user->manager }}</td>
                                    <td class="dynamic-data">{{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                    <td class="dynamic-data"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}</td>
                                    <td class="dynamic-data">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $shipperRate = floatval($s->shipper_load_final_rate);
                                        $carrierFee = floatval($s->load_final_carrier_fee);
                                        $getMargin = $shipperRate - $carrierFee;
                                    @endphp
                                    <td class="dynamic-data" style="color:green;">${{ number_format($getMargin, 2) }}</td>
                                    <td class="dynamic-data">
                                        @if($s->invoice_status == 'Paid') 
                                            Invoiced
                                        @endif
                                    </td>
                                    <!-- <td><button class="btn btn-sm btn-danger">Delete</button></td> -->
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
                
                    <!-- Paid data table -->
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable no-footer">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Sr No</th>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Invoice #</th>
                                    <th style="color: #fff !important;">Invoice Date</th>
                                    <th style="color: #fff !important;">Agent Name</th>
                                    <th style="color: #fff !important;">Office</th>
                                    <th style="color: #fff !important;">Team Leader</th>
                                    <th style="color: #fff !important;">Manager</th>
                                    <th style="color: #fff !important;">Load Creation Date</th>
                                    <th style="color: #fff !important;">Shipper Date</th>
                                    <th style="color: #fff !important;">Delivered Date</th>
                                    <th style="color: #fff !important;">Actual Del Date</th>
                                    <th style="color: #fff !important;">Carrier</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Margin</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($status as $s)
                                @if($s->invoice_status == 'Paid Record')
                                <tr>
                                    <td class="dynamic-data">{{ $i++ }}</td>
                                    <td class="dynamic-data">{{ $s->load_number }}</td>
                                    <td class="dynamic-data">{{ $s->load_workorder }}</td>
                                    <td class="dynamic-data">{{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data">{{ $s->invoice_number }}</td>
                                    <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') }}</td>
                                    <td class="dynamic-data">{{ $s->user->name }}</td>
                                    <td class="dynamic-data">{{ $s->user->office }}</td>
                                    <td class="dynamic-data">{{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data">{{ $s->user->manager }}</td>
                                    <td class="dynamic-data">{{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                    <td class="dynamic-data"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data">{{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}</td>
                                    <td class="dynamic-data">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $shipperRate = floatval($s->shipper_load_final_rate);
                                        $carrierFee = floatval($s->load_final_carrier_fee);
                                        $getMargin = $shipperRate - $carrierFee;
                                    @endphp
                                    <td class="dynamic-data" style="color:green;">${{ number_format($getMargin, 2) }}</td>
                                    <td class="dynamic-data">
                                        @if($s->invoice_status == 'Paid Record') 
                                        Invoiced / Paid
                                        @endif
                                    </td>
                                    <!-- <td><button class="btn btn-sm btn-danger">Delete</button></td> -->
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!-- Bootstrap CSS -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js">
</script>

<script>
    $(document).ready(function () {
        // Initialize Bootstrap tabs
        var tabTriggerEl = document.getElementById('myTab');
        var tab = new bootstrap.Tab(tabTriggerEl);
        tab.show();
    });
</script>

<script>
    // Wait for the document to be fully loaded
    document.addEventListener("DOMContentLoaded", function () {
        // Get all anchor tags in the document
        var anchorTags = document.querySelectorAll("a");

        // Loop through each anchor tag
        anchorTags.forEach(function (anchor) {
            // Set text decoration to unset
            anchor.style.textDecoration = "unset";
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
        // Array of table and input ID pairs
        var tables = [
            { tableClass: '.load_number', inputId: '#loadNumberSearch' },
        ];

        // Loop through each table-input pair
        tables.forEach(function (entry) {
            var table = $(entry.tableClass).DataTable();
            $(entry.inputId).on('keyup', function () {
                table
                    .columns(1)
                    .search(this.value)
                    .draw();
            });
        });
    });
</script>
<script>
    function openUploadWindow(url) {
        // Define the size of the new window
        var width = 1500;   // Width of the new window
        var height = 800;  // Height of the new window

        // Calculate the position to center the window
        var left = screen.width / 2 - width / 2;   // Center horizontally
        var top = screen.height / 2 - height / 2;  // Center vertically

        // Open the new window with the specified URL and properties
        var newWindow = window.open(url, 'UploadWindow', 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left + ',resizable=yes,scrollbars=yes');
        
        // Focus on the new window, if it was successfully opened
        if (newWindow) {
            newWindow.focus();
        }
    }
</script>
@endsection