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
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important;">
            <h2><b>Status Data</b></h2>
        </div>

        <div class="container-fluid p-0">
            <!-- Tab buttons -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"
                        aria-controls="all" aria-selected="true"
                        style="font-size: 15px;color: #000;font-weight:500">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="open-tab" data-bs-toggle="tab" href="#open" role="tab" aria-controls="open"
                        aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Open</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="delivered-tab" data-bs-toggle="tab" href="#delivered" role="tab"
                        aria-controls="delivered" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Delivered</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="completed-tab" data-bs-toggle="tab" href="#completed" role="tab"
                        aria-controls="completed" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Completed</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="invoiced-tab" data-bs-toggle="tab" href="#invoiced" role="tab"
                        aria-controls="invoiced" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Invoiced</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" id="invoiced_paid-tab" data-bs-toggle="tab" href="#invoiced_paid" role="tab"
                        aria-controls="invoiced_paid" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Invoice / Paid</a>
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
                                    <th style="color: #fff !important;">Agent</th>
                                    <th style="color: #fff !important;">Invoice #</th>
                                    <th style="color: #fff !important;">Invoice Date</th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Office</th>
                                    <th style="color: #fff !important;">Team Leader</th>
                                    <th style="color: #fff !important;">Manager</th>
                                    <th style="color: #fff !important;">Load Creation Date</th>
                                    <th style="color: #fff !important;">Shipper Date</th>
                                    <th style="color: #fff !important;">Delivered Date</th>
                                    <th style="color: #fff !important;">Actual Del Date</th>
                                    <th style="color: #fff !important;">Carrier Name</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                    <th style="color: #fff !important;">Margin</th>
                                    <th style="color: #fff !important;">Aging</th>
                                    <th style="color: #fff !important;">CPR Status</th>
                                    <th style="color: #fff !important;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($broker_status as $s)


                                <tr>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" id="load_number" style="vertical-align: middle !important;">
                                      <a style="color: rgb(10 185 90) !important;font-weight: 700;cursor:pointer" onclick="openUploadWindow('{{ route('admin.load.edit', $s->id) }}')">{{ $s->load_number }}</a>
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->user->name }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        @if(!empty($s->invoice_number))
                                        {{ $s->invoice_number }}
                                    @else
                                    -
                                    @endif
                                    </td> 
                                        
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        @if(!empty($s->invoice_date) && $s->invoice_date !== '0000-00-00')
                                            {{ \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_bill_to }}</td>
                                    
                                    
                                   
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->office }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->manager }}</td>
                                    
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                        </td>

                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment, true);
                                        @endphp

                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            @if(!empty($s->load_consignee_appointment) && isset($consignee_appointment[0]['appointment']))
                                                {{ \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            @if(!empty($s->load_actual_delivery_date))
                                            {{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                    </td>

                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        @if($s->load_status == 'Open')
                                            Open
                                        @elseif($s->load_status == 'Delivered' && $s->invoice_status == 'Paid')
                                            Invoiced
                                        @elseif($s->load_status == 'Delivered' && $s->invoice_status != 'Paid' && $s->invoice_status != 'Paid Record')
                                            Delivered
                                        @elseif($s->load_status == 'Delivered' && $s->invoice_status == 'Paid Record')
                                            <span style="color:green">Paid</span>
                                        @endif    
                                    </td>
                                    @php
                                        $shipperRate = floatval($s->shipper_load_final_rate);
                                        $carrierFee = floatval($s->load_final_carrier_fee);
                                        $getMargin = $shipperRate - $carrierFee;
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        ${{ number_format($getMargin, 2) }}
                                    </td>

                                    <td class="dynamic-data">
                                                        @php
                                                            $differenceInDays = null;
                                                            if (isset($s->invoice_date)) {
                                                                $invoiceDate = \Carbon\Carbon::parse($s->invoice_date);
                                                                $currentDate = \Carbon\Carbon::now();
                                                                if ($s->invoice_status == 'Paid') {
                                                                    $differenceInDays = $invoiceDate->diffInDays($currentDate);
                                                                } elseif ($s->invoice_status == 'Paid Record') {
                                                                    // If the invoice status is 'Paid Record', aging is complete
                                                                    $differenceInDays = 'Paid';
                                                                }
                                                            }
                                                            $isInvoiceStatusEmpty = empty($s->invoice_status);
                                                        @endphp

                                                        @if($isInvoiceStatusEmpty)
                                                            <span>-</span>
                                                        @elseif($differenceInDays !== null)
                                                            @if($s->invoice_status == 'Paid')
                                                            <span style="color:red">{{ $differenceInDays }} days</span>
                                                            @elseif($s->invoice_status == 'Paid Record')
                                                                <span style="color:green">{{ $differenceInDays }}</span>
                                                            @endif
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    </td>
                                    @if($s->load_status == "Open")
                                <td class="dynamic-data">{{ $s->cpr_check }}</td>
                                @elseif($s->load_status == "Delivered")
                                <td class="dynamic-data">Verified</td>
                                @elseif($s->load_status !== "Delivered")
                                <td class="dynamic-data">Not Verified</td>
                                @endif
                                    <td class="dynamic-data text-center">
                                        <div class="d-flex">
                                        <a onclick="openUploadWindow('{{ route('admin.load.edit', $s->id) }}')" title="Edit Load">
                                            <i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i>
                                        </a>
                                        <form action="{{ route('admin.destroy.load', $s->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this load?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border: none; background: none;">
                                                <i class="fa fa-trash" style="color: red; font-size: 17px;"></i>
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="open" role="tabpanel" aria-labelledby="delivered-tab">
                    <div class="load-search mb-2">
                        <input type="text" class="form-control" id="loadNumberSearch1" placeholder="Search Load #" style="width: 12%;">
                    </div>
                    <!-- Delivered data table -->
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable no-footer display load_number">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Sr No</th>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">Agent</th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Office</th>
                                    <th style="color: #fff !important;">Team Leader</th>
                                    <th style="color: #fff !important;">Manager</th>
                                    <th style="color: #fff !important;">Load Creation Date</th>
                                    <th style="color: #fff !important;">Shipper Date</th>
                                    <th style="color: #fff !important;">Delivered Date</th>
                                    <!-- <th style="color: #fff !important;">Actual Del Date</th> -->
                                    <th style="color: #fff !important;">Carrier Name</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($broker_status as $s)
                                @if($s->load_status == 'Open')

                                <tr>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" id="load_number1" style="vertical-align: middle !important;">
                                    <a style="color: rgb(10 185 90) !important;font-weight: 700;cursor:pointer" onclick="openUploadWindow('{{ route('admin.load.edit', $s->id) }}')">{{ $s->load_number }}</a></td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->user->name }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_bill_to }}</td>
                                    
                                    
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->office }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            {{ 
                                                isset($consignee_appointment[0]['appointment']) && 
                                                preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $consignee_appointment[0]['appointment']) 
                                                    ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                                    : '' 
                                            }}
                                        </td>

                                        <!-- <td class="dynamic-data" style="vertical-align: middle !important;">
                                            {{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}
                                        </td> -->
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data" style= "vertical-align: middle !important;">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_status }}</td>

                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                   </div>
                </div>

                <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                   
                    <!-- Delivered data table -->
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable no-footer display load_number">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Sr No</th>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">Agent </th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Office</th>
                                    <th style="color: #fff !important;">Team Leader</th>
                                    <th style="color: #fff !important;">Manager</th>
                                    <th style="color: #fff !important;">Load Creation Date</th>
                                    <th style="color: #fff !important;">Shipper Date</th>
                                    <th style="color: #fff !important;">Delivered Date</th>
                                    <th style="color: #fff !important;">Actual Del Date</th>
                                    <th style="color: #fff !important;">Carrier Name</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($broker_status as $s)
                                @if($s->load_status == 'Delivered')

                                <tr>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_number }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->user->name }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_bill_to }}</td>
                                    
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->office }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                            {{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ isset($s->load_actual_delivery_date) ? \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                    </td>

                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_status }}</td>

                                    
                                    
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="delivered-tab">
                  
                    <!-- Delivered data table -->
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable no-footer display load_number">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Sr No</th>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">Agent</th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Office</th>
                                    <th style="color: #fff !important;">Team Leader</th>
                                    <th style="color: #fff !important;">Manager</th>
                                    <th style="color: #fff !important;">Load Creation Date</th>
                                    <th style="color: #fff !important;">Shipper Date</th>
                                    <th style="color: #fff !important;">Delivered Date</th>
                                    <th style="color: #fff !important;">Actual Del Date</th>
                                    <th style="color: #fff !important;">Carrier Name</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($broker_status as $s)
                                @if($s->load_status == 'Completed')

                                <tr>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_number }}</td>
                                        
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->name }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->office }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ isset($s->load_actual_delivery_date) ? \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                    </td>

                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_status }}</td>

                                    
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="invoiced" role="tabpanel" aria-labelledby="delivered-tab">
                  
                    <!-- Delivered data table -->
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable no-footer display load_number">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Sr No</th>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">Agent</th>
                                    <th style="color: #fff !important;">Invoice #</th>
                                    <th style="color: #fff !important;">Invoice Date</th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Office</th>
                                    <th style="color: #fff !important;">Team Leader</th>
                                    <th style="color: #fff !important;">Manager</th>
                                    <th style="color: #fff !important;">Load Creation Date</th>
                                    <th style="color: #fff !important;">Shipper Date</th>
                                    <th style="color: #fff !important;">Delivered Date</th>
                                    <th style="color: #fff !important;">Actual Del Date</th>
                                    <th style="color: #fff !important;">Carrier Name</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($broker_status as $s)
                                @if($s->invoice_status == 'Paid')

                                <tr>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_number }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->user->name }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->invoice_number }}</td> 
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ isset($s->invoice_date) ? \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_bill_to }}</td>

                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->office }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ isset($s->load_actual_delivery_date) ? \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                    </td>

                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    @if($s->invoice_status == 'Paid')
                                        Invoiced
                                    @endif
                                    </td>  
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="invoiced_paid" role="tabpanel" aria-labelledby="delivered-tab">
                   
                    <!-- Delivered data table -->
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable no-footer display load_number">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Sr No</th>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">Agent</th>
                                    <th style="color: #fff !important;">Invoice #</th>
                                    <th style="color: #fff !important;">Invoice Date</th>
                                    <th style="color: #fff !important;">W/O #</th>
                                    <th style="color: #fff !important;">Customer Name</th>
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
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($broker_status as $s)
                                @if($s->invoice_status == 'Paid Record')

                                <tr>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_number }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->user->name }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->invoice_number }}</td> 
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ isset($s->invoice_date) ? \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                      {{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->office }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ isset($s->load_actual_delivery_date) ? \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                    </td>

                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        @if($s->invoice_status)
                                            Invoiced / Paid
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add other tab panes here -->

            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var lastActiveTab = localStorage.getItem('lastActiveTab');
        if (lastActiveTab) {
            $('#myTab a[href="' + lastActiveTab + '"]').tab('show');
        } else {
            // If no last active tab is stored, default to the first tab
            $('#myTab a[data-bs-toggle="tab"]').first().tab('show');
        }

        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetTab = e.target.getAttribute('href');
            localStorage.setItem('lastActiveTab', targetTab);
        });
    });
</script>

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
            { tableClass: '.load_number1', inputId: '#loadNumberSearch1' },
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