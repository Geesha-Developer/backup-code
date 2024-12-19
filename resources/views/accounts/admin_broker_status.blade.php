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
        .table>:not(caption)>*>* {
        background-color: unset !important;
    }
    tbody tr:hover {
    background: #CAF1EB !important;
}
.row-open {
background-color: #f9e79f !important; /* Example color for Open */
}

.row-delivered {
    background-color: #d5dbdb !important; /* Example color for Delivered */
}

.row-delivered-paid {
    background-color: #82e0aa !important; /* Example color for Delivered & Paid */
}

.row-delivered-paid-record {
    background-color: #ffcccb !important; /* Example color for Delivered & Paid Record */
}
.color-pallet .triangle-up {
    margin-right: 5px;
    border: 1px solid #545050;
    padding: 8px;
}
.color-pallet li{
    font-size: 13px;
    display: flex;
    font-weight: 600;
    margin: 0 9px;
    vertical-align: middle;
    align-items: center;
}
.color-pallet hr {
    border: 1px solid rgb(151 151 151);
    margin: 0;
    height: unset;
}
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2><b>Status Data</b></h2>
        </div>

        <div class="container-fluid">
            <!-- Tab buttons -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"
                        aria-controls="all" aria-selected="true" style="font-size: 15px;color: #000;font-weight:500">All
                        Loads Status</a>
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
                    <a class="nav-link" id="paid-tab" data-bs-toggle="tab" href="#paid" role="tab" aria-controls="paid"
                        aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Invoice / Paid</a>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="delivered-tab">
                    <div class="d-flex justify-content-between">
                        <div class="load-search mb-2">
                            <input type="text" class="form-control" id="loadNumberSearch" placeholder="Search Load #">
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <ul class="d-flex color-pallet m-0">
                                <li><div class="triangle-up" style="background: #f9e79f;"></div>Open</li><hr>
                                <li><div class="triangle-up" style="background: #ffcccb;"></div>Delivered</li><hr>
                                <li><div class="triangle-up" style="background: #82e0aa;"></div>Invoiced</li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered js-basic-example dataTable no-footer display load_number" data-page-length="50">
                            <thead>
                               
                                    <th>Sr No</th>
                                    <th>Load #</th>
                                    <th>W/O #</th>
                                    <th>Customer Name</th>
                                    <th>Agent</th>
                                    <th>Office</th>
                                    <th>Team Leader</th>
                                    <th>Manager</th>
                                    <th>Load Creation Date</th>
                                    <th>Shipper Date</th>
                                    <th>Delivered Date</th>
                                    <th>Actual Del Date</th>
                                    <th>Carrier</th>
                                    <th>Pickup Location</th>
                                    <th>Unloading Location</th>
                                    <th>Equipment Type</th>
                                    <th>Load Status</th>
                                    <th>Aging</th>
                                    <th>Action</th>
         
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($status as $s)
                                <tr class="load-row 
                                    @if ($s->load_status === 'Open') 
                                        row-open 
                                    @elseif ($s->load_status === 'Delivered' && $s->invoice_status === 'Paid') 
                                        row-delivered-paid 
                                    @elseif ($s->load_status === 'Delivered' && $s->invoice_status === 'Paid Record') 
                                        row-delivered-paid-record 
                                    @elseif ($s->load_status === 'Delivered') 
                                        row-delivered 
                                    @endif" 
                                    data-created-at="{{ $s->created_at->format('m-d-Y') }}">
                                    
                                    <td class="dynamic-data" style="vertical-align: middle;">{{ $i++ }}</td>
                                    <td class="dynamic-data" id="load_number" style="vertical-align: middle;">
                                          <a style="cursor:pointer;color: #0c7ce6;font-weight: 700;" onclick="openUploadWindow('{{ route('accounting.load.edit', $s->id) }}')">{{ $s->load_number }}</a>
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle;">{{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle;">{{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle;">{{ $s->user->name }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle;">{{ $s->user->office }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle;">{{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle;">{{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle;">{{ \Carbon\Carbon::parse($s->created_at)->format('m-d-Y') }}</td>
                                    @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment, true);
                                        $consignee_appointment = json_decode($s->load_consignee_appointment, true);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle;">
                                        {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                    </td>
                                    <td class="dynamic-data">
                                        {{ isset($consignee_appointment[0]['appointment']) && strtotime($consignee_appointment[0]['appointment']) 
                                            ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                            : '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle;">
                                        {{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle;">
                                        {{ $s->load_carrier }}
                                    </td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location, true);
                                        $consignee_location = json_decode($s->load_consignee_location, true);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle;">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle;">
                                        {{ $consignee_location[0]['location'] ?? '' }}
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle; ">{{ $s->load_equipment_type }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle;">
                                        {{ $s->load_status }}
                                    </td>
                                    @php
                                        $deliveredDate = \Carbon\Carbon::parse($s->created_at);
                                        $currentDate = \Carbon\Carbon::now();
                                        $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle;">  
                                            {{ $differenceInDays }} days
                                    </td>
                                    <td class="dynamic-data">
                                    <a style="cursor: pointer;color: #0c7ce6;font-weight: 700;font-size: 15px;background: #fff;border-radius: 6px;padding: 0 6px;" 
                                        onclick="openUploadWindow('{{ route('accounting.load.edit', ['id' => $s->id]) }}')" title="Edit Load">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                    <!-- Delivered data table -->
                    <div class="load-search mb-2">
                        <input type="text" class="form-control" id="loadNumberSearch1" placeholder="Search Load #" style="width: 12%;">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered js-basic-example dataTable no-footer display load_number1" data-page-length="50">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Load #</th>
                                    <th>W/O #</th>
                                    <th>Customer Name</th>
                                    <th>Agent</th>
                                    <th>Office</th>
                                    <th>Team Leader</th>
                                    <th>Manager</th>
                                    <th>Load Creation Date</th>
                                    <th>Shipper Date</th>
                                    <th>Delivered Date</th>
                                    <th>Actual Del Date</th>
                                    <th>Carrier</th>
                                    <th>Pickup Location</th>
                                    <th>Unloading Location</th>
                                    <th>Load Status</th>
                                    <th>Aging</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($status as $s)
                                @if($s->load_status == 'Delivered')
                                <tr>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" id="load_number1" style=" vertical-align: middle !important;">
                                         <a style="cursor:pointer;color: #0c7ce6;font-weight: 700;" onclick="openUploadWindow('{{ route('accounting.load.edit', $s->id) }}')">{{ $s->load_number }}</a>
                                    </td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->name }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->office }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                        {{ \Carbon\Carbon::parse($s->created_at)->format('m-d-Y') }}
                                    </td>

                                        @php
                                            $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                        </td>

                                
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp

                                        <td class="dynamic-data">
                                            {{ isset($consignee_appointment[0]['appointment']) && strtotime($consignee_appointment[0]['appointment']) 
                                                ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                                : '' }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            {{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->load_carrier }}</td>

                                        @php
                                            $shipper_location = json_decode($s->load_shipper_location, true); 
                                        @endphp
                                        <td class="dynamic-data"
                                            style=" vertical-align: middle !important;">
                                            {{ $shipper_location[0]['location'] ?? '' }}
                                        </td>
                                        @php
                                            $consignee_loaction = json_decode($s->load_consignee_location, true);
                                        @endphp
                                        
                                        <td class="dynamic-data"
                                            style=" vertical-align: middle !important;">
                                            {{ $consignee_loaction[0]['location'] ?? '' }}

                                        </td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                        {{ $s->load_status }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                                            @php
                                                            $deliveredDate = \Carbon\Carbon::parse($s->created_at);
                                                            $currentDate = \Carbon\Carbon::now();
                                                            $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                                            @endphp
                                                            {{ $differenceInDays }} days
                                                        </td>
                                                        <td class="dynamic-data">
                                                        <a style="cursor: pointer;color:#0DCAF0;text-align:center;display: block; font-size: 17px;" 
                                                            onclick="openUploadWindow('{{ route('accounting.load.edit', ['id' => $s->id]) }}')" title="Edit Load">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                    </td>

                                    <!-- <td style=" vertical-align: middle !important;"><button class="btn btn-sm btn-danger">Delete</button></td> -->
                                </tr>
                                @endif

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                    <!-- Completed data table -->
                    <div class="load-search mb-2">
                        <input type="text" class="form-control" id="loadNumberSearch2" placeholder="Search Load #" style="width:12%;">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered js-basic-example dataTable no-footer display load_number2" id="dataTable" data-page-length="50">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Load #</th>
                                    <th>W/O #</th>
                                    <th>Customer Name</th>
                                    <th>Agent</th>
                                    <th>Office</th>
                                    <th>Team Leader</th>
                                    <th>Manager</th>
                                    <th>Load Creation Date</th>
                                    <th>Shipper Date</th>
                                    <th>Delivered Date</th>
                                    <th>Actual Del Date</th>
                                    <th>Carrier</th>
                                    <th>Pickup Location</th>
                                    <th>Unloading Location</th>
                                    <th>Load Status</th>
                                    <th>Aging</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($status as $s)
                                @if($s->load_status == 'Completed')
                                <tr>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" id="load_number2" style=" vertical-align: middle !important;">
                                        <a style="cursor:pointer;color: #0c7ce6;font-weight: 700;" onclick="openUploadWindow('{{ route('accounting.load.edit', $s->id) }}')">{{ $s->load_number }}</a>
                                    </td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->name }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->office }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                        {{ \Carbon\Carbon::parse($s->created_at)->format('m-d-Y') }}
                                    </td>
                                        @php
                                            $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y'): '' }}
                                        </td>

                                
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp

                                        <td class="dynamic-data">
                                            {{ isset($consignee_appointment[0]['appointment']) && strtotime($consignee_appointment[0]['appointment']) 
                                                ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                                : '' }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                           {{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->load_carrier }}</td>

                                        @php
                                            $shipper_location = json_decode($s->load_shipper_location, true); 
                                        @endphp
                                        <td class="dynamic-data"
                                            style=" vertical-align: middle !important;">
                                            {{ $shipper_location[0]['location'] ?? '' }}
                                        </td>
                                        @php
                                            $consignee_loaction = json_decode($s->load_consignee_location, true);
                                        @endphp
                                        
                                        <td class="dynamic-data"
                                            style=" vertical-align: middle !important;">
                                            {{ $consignee_loaction[0]['location'] ?? '' }}

                                        </td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                        {{ $s->load_status }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                                            @php
                                                            $deliveredDate = \Carbon\Carbon::parse($s->created_at);
                                                            $currentDate = \Carbon\Carbon::now();
                                                            $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                                            @endphp
                                                            {{ $differenceInDays }} days
                                                        </td>
                                                        <td class="dynamic-data">
                                                        <a style="cursor: pointer;color:#0DCAF0;text-align:center;display: block; font-size: 17px;" 
                                                            onclick="openUploadWindow('{{ route('accounting.load.edit', ['id' => $s->id]) }}')" title="Edit Load">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                    </td>

                                    <!-- <td style=" vertical-align: middle !important;"><button class="btn btn-sm btn-danger">Delete</button></td> -->
                                </tr>
                                @endif

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="invoiced" role="tabpanel" aria-labelledby="invoiced-tab">
                    <!-- Invoiced data table -->
                    <div class="load-search mb-2">
                        <input type="text" class="form-control" id="loadNumberSearch3" placeholder="Search Load #" style="width:12%;">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered js-basic-example dataTable no-footer display load_number3" id="dataTable" data-page-length="50">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Load #</th>
                                    <th>W/O #</th>
                                    <th>Customer Name</th>
                                    <th>Invoice #</th>
                                    <th>Invoice Date</th>
                                    <th>Agent</th>
                                    <th>Office</th>
                                    <th>Team Leader</th>
                                    <th>Manager</th>
                                    <th>Load Creation Date</th>
                                    <th>Shipper Date</th>
                                    <th>Delivered Date</th>
                                    <th>Actual Del Date</th>
                                    <th>Carrier</th>
                                    <th>Pickup Location</th>
                                    <th>Unloading Location</th>
                                    <th>Load Status</th>
                                    <th>Aging</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($status as $s)
                                @if($s->invoice_status == 'Paid' && $s->invoice_number)
                                <tr>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" id="load_number3" style=" vertical-align: middle !important;">
                                          <a style="cursor:pointer;color: #0c7ce6;font-weight: 700;" onclick="openUploadWindow('{{ route('accounting.load.edit', $s->id) }}')">{{ $s->load_number }}</a>
                                    </td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->invoice_number }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ date('d-m-Y', strtotime($s->invoice_date)) }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->name }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->office }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                        {{ \Carbon\Carbon::parse($s->created_at)->format('m-d-Y') }}
                                    </td>
                                        @php
                                            $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                        </td>

                                
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp

                                        <td class="dynamic-data">
                                            {{ isset($consignee_appointment[0]['appointment']) && strtotime($consignee_appointment[0]['appointment']) 
                                                ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                                : '' }}
                                        </td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            {{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}
                                        </td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $s->load_carrier }}</td>

                                        @php
                                            $shipper_location = json_decode($s->load_shipper_location, true); 
                                        @endphp
                                        <td class="dynamic-data"
                                            style="vertical-align: middle !important;">
                                            {{ $shipper_location[0]['location'] ?? '' }}
                                        </td>
                                        @php
                                            $consignee_loaction = json_decode($s->load_consignee_location, true);
                                        @endphp
                                        
                                        <td class="dynamic-data"
                                            style="vertical-align: middle !important;">
                                            {{ $consignee_loaction[0]['location'] ?? '' }}

                                        </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    @if($s->invoice_status)    
                                        Invoiced
                                    @endif</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                                            @php
                                                            $deliveredDate = \Carbon\Carbon::parse($s->created_at);
                                                            $currentDate = \Carbon\Carbon::now();
                                                            $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                                            @endphp
                                                            {{ $differenceInDays }} days
                                                        </td>
                                                        <td class="dynamic-data">
                                                        <a style="cursor: pointer;color:#0DCAF0;text-align:center;display: block; font-size: 17px;" 
                                                            onclick="openUploadWindow('{{ route('accounting.load.edit', ['id' => $s->id]) }}')" title="Edit Load">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                    </td>

                                    <!-- <td style="vertical-align: middle !important;"><button class="btn btn-sm btn-danger">Delete</button></td> -->
                                </tr>
                                @endif

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
                    <!-- Paid data table -->
                    <div class="load-search mb-2">
                        <input type="text" class="form-control" id="loadNumberSearch4" placeholder="Search Load #" style="width:12%;">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered js-basic-example dataTable no-footer display load_number4" id="dataTable" data-page-length="50">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Load #</th>
                                    <th>W/O #</th>
                                    <th>Customer Name</th>
                                    <th>Invoice #</th>
                                    <th>Invoice Date</th>
                                    <th>Agent</th>
                                    <th>Office</th>
                                    <th>Team Leader</th>
                                    <th>Manager</th>
                                    <th>Load Creation Date</th>
                                    <th>Shipper Date</th>
                                    <th>Delivered Date</th>
                                    <th>Actual Del Date</th>
                                    <th>Carrier</th>
                                    <th>Pickup Location</th>
                                    <th>Unloading Location</th>
                                    <th>Load Status</th>
                                    <th>Aging</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($status as $s)
                                @if($s->invoice_status == 'Paid Record' && $s->invoice_number)
                                <tr>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" id="load_number4" style="vertical-align: middle !important;">
                                          <a style="cursor:pointer;color: #0c7ce6;font-weight: 700;" onclick="openUploadWindow('{{ route('accounting.load.edit', $s->id) }}')">{{ $s->load_number }}</a>
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $s->load_bill_to }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $s->invoice_number }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ date('m-d-Y', strtotime($s->invoice_date)) }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $s->user->name }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $s->user->office }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $s->user->team_lead }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $s->user->manager }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ \Carbon\Carbon::parse($s->created_at)->format('m-d-Y') }}
                                    </td>
                                        @php
                                            $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                        </td>

                                
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp

                                        <td class="dynamic-data">
                                            {{ isset($consignee_appointment[0]['appointment']) && strtotime($consignee_appointment[0]['appointment']) 
                                                ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y')
                                                : '' }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            {{ \Carbon\Carbon::parse($s->created_at)->format('m-d-Y') }}
                                        </td>   
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $s->load_carrier }}</td>

                                        @php
                                            $shipper_location = json_decode($s->load_shipper_location, true); 
                                        @endphp
                                        <td class="dynamic-data"
                                            style=" vertical-align: middle !important;">
                                            {{ $shipper_location[0]['location'] ?? '' }}
                                        </td>
                                        @php
                                            $consignee_loaction = json_decode($s->load_consignee_location, true);
                                        @endphp
                                        
                                        <td class="dynamic-data"
                                            style=" vertical-align: middle !important;">
                                            {{ $consignee_loaction[0]['location'] ?? '' }}

                                        </td>
                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                    @if($s->invoice_status)    
                                        Invoiced / Paid
                                    @endif
                                    </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                                            @php
                                                            $deliveredDate = \Carbon\Carbon::parse($s->created_at);
                                                            $currentDate = \Carbon\Carbon::now();
                                                            $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                                            @endphp
                                                            {{ $differenceInDays }} days
                                                        </td>
                                                        <td class="dynamic-data">
                                                        <a style="cursor: pointer;color:#0DCAF0;text-align:center;display: block; font-size: 17px;" 
                                                            onclick="openUploadWindow('{{ route('accounting.load.edit', ['id' => $s->id]) }}')" title="Edit Load">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                    </td>

                                    <!-- <td style=" vertical-align: middle !important;"><button class="btn btn-sm btn-danger">Delete</button></td> -->
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
</section> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js">
</script>

<!-- 
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
</script> -->

<script>
  $(document).ready(function () {
    // Get the last active tab from localStorage
    var activeTab = localStorage.getItem('activeTab');

    // If there is an active tab stored, activate it
    if (activeTab) {
      $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
    } else {
      // Activate the first tab by default
      $('.nav-tabs a:first').tab('show');
    }

    // Save the active tab to localStorage when a tab is clicked
    $('.nav-tabs a').on('click', function () {
      var tabId = $(this).attr('href');
      localStorage.setItem('activeTab', tabId);
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
            { tableClass: '.load_number2', inputId: '#loadNumberSearch2' },
            { tableClass: '.load_number3', inputId: '#loadNumberSearch3' },
            { tableClass: '.load_number4', inputId: '#loadNumberSearch4' }
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