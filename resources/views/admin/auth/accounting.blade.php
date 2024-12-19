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
    .button {
        display: inline-block;
        padding: 2px 6px;
        font-size: 10px;
        text-align: center;
        text-decoration: none;
        background-color: #4CAF50;
        /* Green */
        color: white;
        border: 1px solid #4CAF50;
        border-radius: 5px;
        cursor: pointer;
    }

    .nav-link.active {
        border: 1px solid #ccc !important;
        border-radius: 6px;
        background: #555555;
        color: #fff !important;
    }
    tbody tr td .dropdown-menu.show {
    width: max-content;
    transform: translate3d(-139px, 41px, 0px) !important;
}
    .modal {
        background: #000000b3;
    }

    #view-file .modal-header h4 {
        background: unset;
        color: #000;
        font-weight: 700;
        font-size: 21px;
    }

    #view-file .modal .modal-header .close {
        color: #000000;
        text-shadow: none;
        font-size: 35px;
        margin-top: 6px;
    }

    #view-file .modal-body #file-list button {
        background: no-repeat;
        border-bottom: 2px solid #747473 !important;
        border: none;
        width: 100%;
        text-align: left;
        font-weight: 600;
        color: #747473;
    }

    .modal h4.modal-title {
        font-size: 16px;
        text-align: center;
        background: #555555;
        color: #fff;
        margin: 0;
        padding: 4px 0;
    }
   .dropdown-menu li a:hover {
    color: #fff !important;
    cursor: pointer;
}
    .modal button.close {
        position: absolute;
        right: 38px;
        top: 30px;
        color: #fff;
    }

    .modal .form-group label {
        margin-bottom: 0;
        font-weight: 600;
        font-size: 15px;
        color: #4a4a4a;
    }
    .modal form .form-group {
        margin: 4px 0 17px 0;
    }

    .upload-button input#upload {
        position: absolute;
        right: -9999px;
        visibility: hidden;
        opacity: 0;
    }

    #selectedFiles div {
        border: 1px solid #ccc;
        margin: 12px 0;
        padding: 0 9px;
        border-radius: 6px;
        background: lightgrey;
    }

    #selectedFiles div span.deleteFile {
        position: absolute;
        right: 39px;
        font-size: 22px;
        margin: -4px 0;
        color: red;
    }

    .upload-button p.choose-file {
        padding: 24px 0;
        font-size: 18px;
        color: #728f22;
    }

    label.upload-button {
        text-align: center;
        border: 1px solid #ccc;
        height: 80px;
        border-radius: 8px;
    }

    .form-group p {
        margin-bottom: 4px;
        font-size: 13px;
        color: #817d7d;
    }

    li {
        list-style: none;
    }

    .modal .modal-body ul li {
        0 padding: 11px 12px;
        border-radius: 3px;
        margin-top: 10px;
    }

    i#uploadIcon {
        padding: 30px 6px;
        font-size: 30px;
        color: #728f22;
        width: 100%;
        display: flex;
        justify-content: center;
        border: 1px solid #ccc;
        border-radius: 7px;
    }

    .modal .modal-body ul {
        padding-inline-start: 0;
    }

    .btn-danger {
        background-color: unset;
        color: red;
    }

    .btn-warning {
        background-color: unset;
        color: #FF9948;
    }

    .btn-sm {
        font-size: 12px;
        border-radius: .2875rem;
        padding: 5px 4px;
    }
    .dropdown-menu.show {
    width: max-content;
}
</style>
<section class="content">
    <div class="body_scroll">
        <!-- Tabs With Icon Title -->
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="card">
                    <div class="block-header">
                        <h2><b>Accounting Data Management</b></h2>
                    </div>
                    <div class="container-fluid">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="myTab" style="padding: 4px 0 4px 0;">
                            <li class="nav-item">
                                <a class="nav-link active" id="open-tab" data-bs-toggle="tab" role="tab"
                                    aria-controls="open" aria-selected="true" style="font-size:15px;"
                                    href="#open_with_icon_title"> Open
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="delivered-tab" data-bs-toggle="tab" role="tab"
                                    aria-controls="delivered" aria-selected="true" style="font-size:15px;"
                                    href="#home_with_icon_title"> Delivered
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="completed-tab" data-bs-toggle="tab" role="tab"
                                    aria-controls="completed" aria-selected="false"
                                    style="font-size:15px;" href="#profile_with_icon_title">Completed
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="invoiced-tab" data-bs-toggle="tab" role="tab"
                                    aria-controls="invoiced" aria-selected="false"
                                    style="font-size:15px;" href="#messages_with_icon_title">Invoiced
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="invoiced-paid-tab" data-bs-toggle="tab" role="tab"
                                    aria-controls="invoicedpaid" aria-selected="false"
                                    style="font-size:15px;" href="#settings_with_icon_title">Invoice / Paid
                                </a>
                            </li>
                        </ul>



                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" role="tabpanel" id="open_with_icon_title"
                                aria-labelledby="open-tab">
                                <div class="body p-0">
                                    <div class="table-responsive">
                                        <div class="col-md-12 text-center date-time mb-2">
                                            <div class="date">
                                                <label for="start">Start Date</label>
                                                <input id="start" class="start_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>
                                            <div class="date" style="margin-left: 14px;">
                                                <label for="end">End Date</label>
                                                <input id="end" class="end_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>

                                            <select name="manager" id="manager" class="manager_filter filter-dropdown" style="margin-left:7px; margin-top: 17px; height: 20px;color: #3e3e40;">
                                                <option value="" selected>Sort By Manager</option>
                                                <option value="Adam Smith">Adam Smith</option>
                                                @php $managers = \App\Models\Manger::get(); @endphp
                                                @foreach($managers as $manager)
                                                <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                                                @endforeach
                                            </select>

                                            <select name="team_lead" id="team_lead"
                                                class="team_lead_filter filter-dropdown"
                                                style="height: 20px;color: #3e3e40;margin-left:7px; margin-top: 17px;">
                                                <option value="" selected>Sort By TL</option>
                                                @php $teamlead = \App\Models\TeamLeader::get(); @endphp
                                                @foreach($teamlead as $teamLead)
                                                <option value="{{ $teamLead->tl }}">{{ $teamLead->tl }}</option>
                                                @endforeach
                                            </select>

                                        
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Load #</th>
                                                    <th>W/O #</th>
                                                    <th>Customer Name</th>
                                                    <th>Customer Final Rate</th>
                                                    <th>Agent</th>
                                                    <th>Office</th>
                                                    <th>Team Leader</th>
                                                    <th>Manager</th>
                                                    <th>Load Creation Date</th>
                                                    <th>Shipper Date</th>
                                                    <th>Delivered Date</th>
                                                    <th>Carrier</th>
                                                    <th>Carrier Final Rate</th>
                                                    <th>Load Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                use App\Models\Load;
                                                $load_open = Load::where('load_status', 'Open')->get();
                                                $i = 1;
                                                @endphp
                                                @foreach($load_open as $open)
                                                <tr>
                                                    <td class="dynamic-data">{{ $i++ }}</td>
                                                    <td class="dynamic-data" id="load_number">
                                                        <a style="color: rgb(10 185 90) !important;font-weight: 700;cursor:pointer" onclick="openUploadWindow('{{ route('accounting.load.edit', $open->id) }}')">{{ $open->load_number }}</a>
                                                    </td>
                                                    <td class="dynamic-data">{{ $open->load_workorder }}</td>
                                                    <td class="dynamic-data">{{ $open->load_bill_to }}</td>
                                                    <td class="dynamic-data">{{ $open->shipper_load_final_rate }}</td>
                                                    <td class="dynamic-data">{{ $open->user->name }}</td>
                                                    <td class="dynamic-data">{{ $open->user->office }}</td>
                                                    <td class="dynamic-data">{{ $open->user->team_lead }}</td>
                                                    <td class="dynamic-data">{{ $open->user->manager }}</td>
                                                    <td class="dynamic-data">
                                                        {{ $open->created_at->format('m-d-Y') }}</td>
                                                    @php
                                                    $shipper_appointment =
                                                    json_decode($open->load_shipper_appointment,true);
                                                    @endphp
                                                    <td class="dynamic-data">
                                                        {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                                    </td>
                                                    @php
                                                    $consignee_appointment =
                                                    json_decode($open->load_consignee_appointment,true);
                                                    @endphp
                                                    <td class="dynamic-data">
                                                    {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                                    </td>

                                                    <td class="dynamic-data">{{$open->load_carrier}}</td>
                                                    <td class="dynamic-data">{{$open->load_final_carrier_fee}}</td>

                                                    <td class="dynamic-data">
                                                        {{ $open->load_status }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="home_with_icon_title"
                                aria-labelledby="delivered-tab">
                                <div class="body p-0">
                                    <div class="table-responsive">
                                        <div class="col-md-12 text-center date-time mb-2">
                                            <div class="date">
                                                <label for="start">Start Date</label>
                                                <input id="start" class="start_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>
                                            <div class="date" style="margin-left: 14px;">
                                                <label for="end">End Date</label>
                                                <input id="end" class="end_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>

                                            <select name="manager" id="manager" class="manager_filter filter-dropdown" style="margin-left:7px; margin-top: 17px; height: 20px;color: #3e3e40;">
                                                <option value="" selected>Sort By Manager</option>
                                                <option value="Adam Smith">Adam Smith</option>
                                                @php $managers = \App\Models\Manger::get(); @endphp
                                                @foreach($managers as $manager)
                                                <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                                                @endforeach
                                            </select>

                                            <select name="team_lead" id="team_lead"
                                                class="team_lead_filter filter-dropdown"
                                                style="height: 20px;color: #3e3e40;margin-left:7px; margin-top: 17px;">
                                                <option value="" selected>Sort By TL</option>
                                                @php $teamlead = \App\Models\TeamLeader::get(); @endphp
                                                @foreach($teamlead as $teamLead)
                                                <option value="{{ $teamLead->tl }}">{{ $teamLead->tl }}</option>
                                                @endforeach
                                            </select>

                                        
                                        </div>

                                        <table id="dataTable" class="table table-bordered" data-page-length="50">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Load #</th>
                                                    <th>W/O #</th>
                                                    <th>Customer Name</th>
                                                    <th>Customer Final Rate</th>
                                                    <th>Agent</th>
                                                    <th>Office</th>
                                                    <th>Team Leader</th>
                                                    <th>Manager</th>
                                                    <th>Load Creation Date</th>
                                                    <th>Shipper Date</th>
                                                    <th>Delivered Date</th>
                                                    <th>Actual Del Date</th>
                                                    <th>Carrier</th>
                                                    <th>Carrier Final Rate</th>
                                                    <th>Pickup Location</th>
                                                    <th>Unloading Location</th>
                                                    <th>Load Status</th>
                                                    <th>Margin</th>
                                                    <th>Aging</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 1; @endphp
                                                @foreach($loads as $delivered)
                                                    @if($delivered->load_status == 'Delivered' && 
                                                        !in_array($delivered->invoice_status, ['Completed', 'Paid', 'Paid Record']))
                                                        <tr>
                                                            <td class="dynamic-data">{{ $i++ }}</td>
                                                            <td class="dynamic-data">
                                                                  <a style="color: rgb(10 185 90) !important; font-weight: 700;cursor:pointer" onclick="openUploadWindow('{{ route('accounting.load.edit', $delivered->id) }}')">{{ $delivered->load_number }}</a>
                                                            </td>
                                                            <td class="dynamic-data">{{ $delivered->load_workorder }}</td>
                                                            <td class="dynamic-data">{{ $delivered->load_bill_to }}</td>
                                                            <td class="dynamic-data">{{ $delivered->shipper_load_final_rate }}</td>
                                                            <td class="dynamic-data">{{ $delivered->user->name }}</td>
                                                            <td class="dynamic-data">{{ $delivered->user->office }}</td>
                                                            <td class="dynamic-data">{{ $delivered->user->team_lead }}</td>
                                                            <td class="dynamic-data">{{ $delivered->user->manager }}</td>
                                                            <td class="dynamic-data">{{ \Carbon\Carbon::parse($delivered->created_at)->format('m-d-Y') }}</td>
                                                            @php
                                                                $shipper_appointment = json_decode($delivered->load_shipper_appointment, true);
                                                            @endphp
                                                            <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                                            @php
                                                                $consignee_appointment = json_decode($delivered->load_consignee_appointment, true);
                                                            @endphp
                                                            <td class="dynamic-data">{{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                                            <td class="dynamic-data">{{ \Carbon\Carbon::parse($delivered->load_actual_delivery_date)->format('m-d-Y') }}</td>
                                                            <td class="dynamic-data">{{ $delivered->load_carrier }}</td>
                                                            <td class="dynamic-data">{{ $delivered->load_final_carrier_fee }}</td>
                                                            @php
                                                                $shipper_location = json_decode($delivered->load_shipper_location, true);
                                                            @endphp
                                                            <td class="dynamic-data">
                                                                {{ isset($consignee_appointment[0]['appointment']) && strtotime($consignee_appointment[0]['appointment']) 
                                                                    ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                                                    : '' }}
                                                            </td>
                                                            @php
                                                                $consignee_location = json_decode($delivered->load_consignee_location, true);
                                                                $last_consignee_location = is_array($consignee_location) ? end($consignee_location) : null;
                                                            @endphp
                                                            <td class="dynamic-data">{{ $last_consignee_location['location'] ?? '' }}</td>

                                                            <td class="dynamic-data">{{ $delivered->load_status }}</td>
                                                            @php
                                                                $shipperRate = floatval($delivered->shipper_load_final_rate);
                                                                $carrierFee = floatval($delivered->load_final_carrier_fee);
                                                                $getMargin = $shipperRate - $carrierFee;
                                                            @endphp
                                                            <td class="dynamic-data" style="color: {{ $getMargin >= 0 ? 'green' : 'red' }};">
                                                                {{ number_format($getMargin, 2) }}
                                                            </td>
                                                            <td class="dynamic-data">{{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($delivered->created_at)) }} days</td>
                                                            <td class="dynamic-data">
                                                                <a id="markAsCompletedBtn_{{ $delivered->id }}" style="color:#0062cc;" class="text-left {{ in_array($delivered->invoice_status, ['Deliverd', 'Delivered']) ? 'success' : 'danger' }}" onclick="markAsCompleted({{ $delivered->id }})">
                                                                    @if(in_array($delivered->invoice_status, ['Deliverd', 'Delivered']))
                                                                        Completed
                                                                    @else
                                                                        <i class="fa fa-check" style="font-size: 15px;"></i>
                                                                    @endif
                                                                </a>
                                                                <a onclick="openUploadWindow('{{ route('accounting.load.edit', $delivered->id) }}')" style="cursor:pointer;color: #0d6efd;" title="Edit Load">
                                                                     <i class="fa fa-pen" style="font-size: 15px;"></i>
                                                                </a>
                                                                <a onclick="openModal({{ $delivered->id }})" style="color:#0062cc;" data-toggle="modal" data-target="#view-file">
                                                                    <i class="fa fa-eye" style="font-size: 15px;"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="profile_with_icon_title"
                                aria-labelledby="completed-tab">
                                <div class="body p-0">
                                    <div class="table-responsive">
                                    <div class="col-md-12 text-center date-time mb-2">
                                            <div class="date">
                                                <label for="start">Start Date</label>
                                                <input id="start" class="start_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>
                                            <div class="date" style="margin-left: 14px;">
                                                <label for="end">End Date</label>
                                                <input id="end" class="end_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>
                                            <select name="manager" id="delivered_manager" class="manager_filter filter-dropdown" style="margin-left:7px; margin-top: 17px; height: 20px;color: #3e3e40;">
                                                <option value="" selected>Sort By Manager</option>
                                                <option value="Adam Smith">Adam Smith</option>
                                                @php $managers = \App\Models\Manger::get(); @endphp
                                                @foreach($managers as $manager)
                                                <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                                                @endforeach
                                            </select>

                                            <select name="team_lead" id="delivered_team_lead"
                                                class="team_lead_filter filter-dropdown"
                                                style="height: 20px;color: #3e3e40;margin-left:7px; margin-top: 17px;">
                                                <option value="" selected>Sort By TL</option>
                                                @php $teamlead = \App\Models\TeamLeader::get(); @endphp
                                                @foreach($teamlead as $teamLead)
                                                <option value="{{ $teamLead->tl }}">{{ $teamLead->tl }}</option>
                                                @endforeach
                                            </select>
                                        
                                        </div>
                                        <table class="table table-bordered dataTable no-footer" data-page-length="50">
                                        <thead>
                                                <tr>
                                                    <th>Sr No.</th>
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
                                                    <th>Margin</th>
                                                    <th>Aging</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $i=1;
                                                @endphp
                                                @foreach($loads_completed as $completed)

                                                <tr>
                                                    <td class="dynamic-data">{{ $i++ }}</td>

                                                    <td class="dynamic-data">
                                                        <a style="color: rgb(10 185 90) !important;font-weight: 700;cursor:pointer" onclick="openUploadWindow('{{ route('accounting.load.edit', $completed->id) }}')">{{ $completed->load_number }}</a>
                                                    </td>
                                                    <td class="dynamic-data">{{ $completed->load_workorder }}</td>
                                                    <td class="dynamic-data">{{ $completed->load_bill_to }}</td>
                                                    <td class="dynamic-data">
                                                        {{$completed->user->name}}
                                                    </td>

                                                    <td class="dynamic-data">{{ $completed->user->office }}</td>
                                                    <td class="dynamic-data tl-column">{{ $completed->user->team_lead }}</td>
                                                    <td class="dynamic-data manager-column">{{ $completed->user->manager }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $completed->created_at->format('m-d-y') }}</td>
                                                    @php
                                                    $shipper_appointment =
                                                    json_decode($completed->load_shipper_appointment,true);
                                                    @endphp
                                                    <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                                    </td>
                                                    @php
                                                    $consignee_appointment =
                                                    json_decode($completed->load_consignee_appointment,true);
                                                    @endphp
                                                    <td class="dynamic-data"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                                    </td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $completed->load_actual_delivery_date }}
                                                    </td>
 
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $completed->load_carrier }}
                                                    </td>
                                                    @php
                                                    $shipper_location = json_decode($completed->load_shipper_location,
                                                    true);
                                                    @endphp
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $shipper_location[0]['location'] ?? '' }}
                                                    </td>

                                                    @php
                                                    $consignee_loaction =
                                                    json_decode($completed->load_consignee_location, true);
                                                    @endphp

                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                                    </td>


                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        @if($completed->invoice_status == 'Completed')
                                                        Completed
                                                        @endif
                                                    </td>
                                                    @php
                                                        $shipperRate = floatval($completed->shipper_load_final_rate);
                                                        $carrierFee = floatval($completed->load_final_carrier_fee);
                                                        $getMargin = $shipperRate - $carrierFee;
                                                    @endphp
                                                    <td class="dynamic-data" style="color:green;">${{ number_format($getMargin, 2) }}</td>
                                                    <td class="dynamic-data">
                                                        @if($completed->load_status == 'Delivered' ||
                                                        $completed->invoice_status == null)
                                                        @php
                                                        $deliveredDate = \Carbon\Carbon::parse($completed->created_at);
                                                        $currentDate = \Carbon\Carbon::now();
                                                        $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                                        @endphp
                                                        {{ $differenceInDays }} days
                                                        @elseif($completed->invoice_status == 'paid' ||
                                                        $completed->load_status == 'Delivered')
                                                        Aging Complete
                                                        @endif
                                                    </td>

                                                    <td class="dynamic-data">
                                                        <a id="markAsPaidBtn_{{ $completed->id }}"  style="color: #0062cc;cursor:pointer;"
                                                            class="text-left{{ $completed->invoice_status === 'Paid' ? 'success' : 'danger' }} btn-sm"
                                                            onclick="markAsPaid({{ $completed->id }})">
                                                            @if($completed->invoice_status
                                                            === 'Paid')
                                                            Paid
                                                            @else
                                                            <i class="fa fa-check" style="font-size: 15px; " aria-hidden="true"></i>
                                                            @endif
                                                        </a>
                                                        <a onclick="openModal({{ $completed->id }})" data-toggle="modal" data-target="#view-file" style="cursor:pointer;color: #0d6efd;"><i
                                                                class="fa fa-eye" style="font-size: 15px; "></i></a>
                                                        <a onclick="openUploadWindow('{{ route('accounting.load.edit', $completed->id) }}')" style="cursor:pointer;color: #0d6efd;" title="Edit Load">
                                                            <i class="fa fa-pen" style="font-size: 15px; "></i>
                                                        </a>
                                                        <a href="#" onclick="markAsBackDeliveredRecord({{ $completed->id }})">
                                                            <i class="fas fa-reply" style="font-size: 15px;"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="messages_with_icon_title"
                                aria-labelledby="invoiced-tab">
                                <div class="body p-0">
                                    <div class="table-responsive">
                                    <div class="col-md-12 text-center date-time mb-2">
                                            <div class="date">
                                                <label for="start">Start Date</label>
                                                <input id="start" class="start_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>
                                            <div class="date" style="margin-left: 14px;">
                                                <label for="end">End Date</label>
                                                <input id="end" class="end_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>
                                            <select name="manager" id="invoice_manager" class="manager_filter filter-dropdown" style="margin-left:7px; margin-top: 17px; height: 20px;color: #3e3e40;">
                                                <option value="" selected>Sort By Manager</option>
                                                <option value="Adam Smith">Adam Smith</option>
                                                @php $managers = \App\Models\Manger::get(); @endphp
                                                @foreach($managers as $manager)
                                                <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                                                @endforeach
                                            </select>

                                            <select name="team_lead" id="invoice_team_lead"
                                                class="team_lead_filter filter-dropdown"
                                                style="height: 20px;color: #3e3e40;margin-left:7px; margin-top: 17px;">
                                                <option value="" selected>Sort By TL</option>
                                                @php $teamlead = \App\Models\TeamLeader::get(); @endphp
                                                @foreach($teamlead as $teamLead)
                                                <option value="{{ $teamLead->tl }}">{{ $teamLead->tl }}</option>
                                                @endforeach
                                            </select>
                                        
                                        </div>
                                        <table class="table table-bordered dataTable" data-page-length="50">
                                        <thead>
                                                <tr>
                                                    <th>Sr No.</th>
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
                                                    <th>Margin</th>
                                                    <th>Aging</th>
                                                    <th>Shipper Final Rate</th>
                                                    <th>Shipper Receiving Amount</th>
                                                    <th>Shipper Remaining Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $i=1;
                                                @endphp
                                                @foreach($loads_paid as $invoice)
                                                @if($invoice->invoice_status === 'Paid' && $invoice->invoice_status !==
                                                'Deliverd' && $invoice->invoice_status !== 'Delivered' &&
                                                $invoice->invoice_status !== 'Completed')

                                                <tr>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $i++ }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                         <a style="color: rgb(10 185 90) !important;font-weight: 700;cursor:pointer" onclick="openUploadWindow('{{ route('accounting.load.edit', $invoice->id) }}')">{{ $invoice->load_number }}</a>
                                                    </td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $invoice->load_workorder }}</td>

                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $invoice->user->name }}
                                                    </td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $invoice->invoice_number }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ date('m-d-Y', strtotime($invoice->invoice_date)) }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $invoice->load_bill_to }}</td>


                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $invoice->user->office }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $invoice->user->team_lead }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $invoice->user->manager }}</td>
                                                        <td class="dynamic-data"
                                                            style=" vertical-align: middle !important;">
                                                            {{ \Carbon\Carbon::parse($invoice->created_at)->format('m-d-Y') }}
                                                        </td>

                                                    @php
                                                    $shipper_appointment =
                                                    json_decode($delivered->load_shipper_appointment,true);
                                                    @endphp
                                                    <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                                    </td>
                                                    @php
                                                    $consignee_appointment =
                                                    json_decode($delivered->load_consignee_appointment,true);
                                                    @endphp
                                                    <td class="dynamic-data"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                                    </td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ \Carbon\Carbon::parse($invoice->load_actual_delivery_date)->format('m-d-Y') }}
                                                    </td>

                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $invoice->load_carrier }}</td>
                                                    @php
                                                    $shipper_location = json_decode($invoice->load_shipper_location,
                                                    true);
                                                    @endphp
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $shipper_location[0]['location'] ?? '' }}
                                                    </td>

                                                    @php
                                                    $consignee_loaction = json_decode($invoice->load_consignee_location,
                                                    true);
                                                    @endphp

                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                                    </td>

                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        @if($invoice->invoice_status == 'Paid')
                                                        Invoiced
                                                        @endif

                                                    </td>
                                                    @php
                                                        $shipperRate = floatval($invoice->shipper_load_final_rate);
                                                        $carrierFee = floatval($invoice->load_final_carrier_fee);
                                                        $getMargin = $shipperRate - $carrierFee;
                                                    @endphp
                                                    <td class="dynamic-data" style="color:green;">${{ number_format($getMargin, 2) }}</td>
                                                    <td class="dynamic-data">
                                                        @if($invoice->load_status == 'Delivered' ||
                                                        $invoice->invoice_status == 'Completed' )
                                                        @php
                                                        $deliveredDate = \Carbon\Carbon::parse($invoice->created_at);
                                                        $currentDate = \Carbon\Carbon::now();
                                                        $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                                        @endphp
                                                        {{ $differenceInDays }} days
                                                        @elseif($invoice->invoice_status == 'Completed' ||
                                                        $invoice->load_status == 'Delivered')
                                                        Aging Complete
                                                        @endif
                                                    </td>
                                                    <td class="dynamic-data">{{ $invoice->shipper_load_final_rate }}</td>
                                                    <td class="dynamic-data">
                                                        <input type="number" class="form-control receiving_amount"
                                                            name="receiving_amount" data-invoice-id="{{ $invoice->id }}"
                                                            data-shipper-load-final-rate="{{ $invoice->shipper_load_final_rate }}"
                                                            id="receiving_amount_{{ $invoice->id }}"
                                                            value="{{ $invoice->receiving_amount }}">
                                                    </td>
                                                    @php
                                                    $shipperLoadFinalRate = floatval($invoice->shipper_load_final_rate);
                                                    $receivingAmount = floatval($invoice->receiving_amount);
                                                    $remaining = max($shipperLoadFinalRate - $receivingAmount, 0);
                                                    @endphp
                                                    <td class="dynamic-data">
                                                        <input type="text" readonly class="remaining_amount form-control" name="remaining_amount" id="remaining_amount_{{ $invoice->id }}" value="{{ number_format($remaining, 2) }}">
                                                    </td>


                                                    <td class="dynamic-data">
                                                        <a id="markAsPaidRecordBtn_{{ $invoice->id }}" style="color: #0062cc; cursor:pointer;"
                                                            class="{{ $invoice->invoice_status === 'Paid Record' ? 'success' : 'danger' }}"
                                                            onclick="markAsPaidRecord({{ $invoice->id }})"><i class="fa fa-check"
                                                                style="font-size: 15px;" aria-hidden="true"></i>
                                                        </a>
                                                        <a onclick="openModal({{ $invoice->id }})" data-toggle="modal" data-target="#view-file" style="color: #0062cc;cursor:pointer;"><i
                                                                class="fa fa-eye" style="font-size: 15px;"></i></a>
                                                        <a onclick="openUploadWindow('{{ route('accounting.load.edit', $invoice->id) }}')" style="cursor:pointer;color: #0d6efd;" title="Edit Load">
                                                            <i class="fa fa-pen" style="font-size: 15px;"></i>
                                                        </a>
                                                        <a class="text-left" href="#" onclick="markAsBackCompleteRecord({{ $invoice->id }})">
                                                            <i class="fas fa-reply" style="font-size: 15px;"></i>
                                                        </a>
                                                        <a href="#" class="text-left" data-toggle="modal" data-target="#customMailModal">
                                                            <i class="fas fa-envelope-open" style="font-size: 15px;"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" onclick="printPreInvoice({{ $invoice->id }})">
                                                            <i class="fa fa-print" style="font-size: 15px;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="settings_with_icon_title"
                                aria-labelledby="invoiced-paid-tab">
                                <div class="body p-0">
                                    <div class="table-responsive">
                                    <div class="col-md-12 text-center date-time mb-2">
                                            <div class="date">
                                                <label for="start">Start Date</label>
                                                <input id="start" class="start_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>
                                            <div class="date" style="margin-left: 14px;">
                                                <label for="end">End Date</label>
                                                <input id="end" class="end_filter filter-dropdown"
                                                    style="height: 20px;color: #3e3e40;" type="date" />
                                            </div>

                                            <select name="manager" id="record_manager" class="manager_filter filter-dropdown" style="margin-left:7px; margin-top: 17px; height: 20px;color: #3e3e40;">
                                                <option value="" selected>Sort By Manager</option>
                                                <option value="Adam Smith">Adam Smith</option>
                                                @php $managers = \App\Models\Manger::get(); @endphp
                                                @foreach($managers as $manager)
                                                <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                                                @endforeach
                                            </select>

                                            <select name="team_lead" id="record_team_lead"
                                                class="team_lead_filter filter-dropdown"
                                                style="height: 20px;color: #3e3e40;margin-left:7px; margin-top: 17px;">
                                                <option value="" selected>Sort By TL</option>
                                                @php $teamlead = \App\Models\TeamLeader::get(); @endphp
                                                @foreach($teamlead as $teamLead)
                                                <option value="{{ $teamLead->tl }}">{{ $teamLead->tl }}</option>
                                                @endforeach
                                            </select>

                                          
                                        
                                        </div>
                                        <table class="table table-bordered dataTable no-footer" data-page-length="50">
                                        <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Load #</th>
                                                    <th>W/O #</th>
                                                    <th>Customer Name</th>
                                                    <th>Invoice #</th>
                                                    <th>Invoice Date</th>
                                                    <th>Customer Receiving Payment Date</th>
                                                    <th>Agent</th>
                                                    <th>Office</th>
                                                    <th>Team Leader</th>
                                                    <th>Manager</th>
                                                    <th>Load Creation Date</th>
                                                    <th>Shipper Date</th>
                                                    <th>Delivered Date</th>
                                                    <th>Carrier</th>
                                                    <th>Pickup Location</th>
                                                    <th>Unloading Location</th>
                                                    <th>Load Status</th>
                                                    <th>Magin</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $i=1;
                                                @endphp
                                                @foreach($loads_paid_record as $record)
                                                <tr>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $i++ }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                         <a style="color: rgb(10 185 90) !important;font-weight: 700;cursor:pointer" onclick="openUploadWindow('{{ route('accounting.load.edit', $record->id) }}')">{{ $record->load_number }}</a>
                                                    </td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $record-> load_workorder }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $record-> load_bill_to }}
                                                    </td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $record->invoice_number }}</td>
                                                        <td class="dynamic-data"
                                                            style=" vertical-align: middle !important;">
                                                            {{ \Carbon\Carbon::parse($record->invoice_date)->format('m-d-Y') }}
                                                        </td>
                                                        <td class="dynamic-data"
                                                            style=" vertical-align: middle !important;">
                                                            {{ \Carbon\Carbon::parse($record->invoice_status_date)->format('m-d-Y') }}
                                                        </td>
                                                    <td class="dynamic-data">
                                                        {{ $record->user->name }}
                                                    </td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $record->user->office }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $record-> user->team_lead }}</td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $record->user->manager }}</td>

                                                        <td class="dynamic-data"
                                                            style=" vertical-align: middle !important;">
                                                            {{ \Carbon\Carbon::parse($record->created_at)->format('m-d-Y') }}
                                                        </td>
                                                    @php
                                                    $shipper_appointment =
                                                    json_decode($delivered->load_shipper_appointment,true);
                                                    @endphp
                                                    <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('y-m-d') : '' }}
                                                    </td>
                                                    @php
                                                    $consignee_appointment =
                                                    json_decode($delivered->load_consignee_appointment,true);
                                                    @endphp
                                                    <td class="dynamic-data"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('y-m-d') : '' }}
                                                    </td>
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $record->load_carrier }}</td>
                                                    @php
                                                    $shipper_location = json_decode($record->load_shipper_location,true);
                                                    @endphp
                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $shipper_location[0]['location'] ?? '' }}
                                                    </td>
                                                    @php
                                                    $consignee_loaction = json_decode($record->load_consignee_location,true);
                                                    @endphp

                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                                    </td>

                                                    <td class="dynamic-data"
                                                        style=" vertical-align: middle !important;">
                                                        @if($record->invoice_status == 'Paid Record')
                                                        Invoiced</td>
                                                    @endif
                                                    @php
                                                        $shipperRate = floatval($record->shipper_load_final_rate);
                                                        $carrierFee = floatval($record->load_final_carrier_fee);
                                                        $getMargin = $shipperRate - $carrierFee;
                                                    @endphp
                                                    <td class="dynamic-data" style="color:green;">${{ number_format($getMargin, 2) }}</td>
                                                    <td class="dynamic-data">
                                                        <a onclick="openUploadWindow('{{ route('accounting.load.edit', $record->id) }}')" style="cursor:pointer;color: #0d6efd;" title="Edit Load">
                                                            <i class="fa fa-pen" style="font-size: 15px;"></i>
                                                        </a>
                                                        <a onclick="openModal({{ $record->id }})" style="color: #0062cc;cursor:pointer;" data-toggle="modal" data-target="#view-file"><i class="fa fa-eye"
                                                                style="font-size: 15px;"></i></a>
                                                        <a href="javascript:void(0);"
                                                            onclick="markAsBackInvoiceRecord({{ $record->id }})">
                                                            <i class="fas fa-reply"
                                                                style="font-size: 15px;"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            onclick="printInvoice({{ $record->id }})">
                                                            <i class="fa fa-print"
                                                                style="font-size: 15px;"></i>
                                                        </a>
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
        </div>
    </div>
</section>
<!-- file view popup start -->

<div class="modal" id="view-file">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Files</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul id="file-list"></ul>
                <button id="mergeButton" type="button" class="btn btn-primary"><i class="fa fa-file-pdf-o"></i> Merge
                    Documents</button>
            </div>
        </div>

    </div>
</div>
</div>
<!-- edit-data popup end -->

<!-- CUSTOMER DETAILS popup start -->
<div class="modal" id="customer-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0 m-0">
                <h4 class="modal-title">CUSTOMER DETAILS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="card-body text-left">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Customer Name <code>*</code></label>
                                <input class="form-control select2" type="text" required="" name="customer_name"
                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <input type="text" name="user_id" hidden="">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mr-2">MC# /FF# <code>*</code></label>
                                <div class="d-flex" style="width: 100%;  ">
                                    <select
                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 30% !important;height:30px"
                                        class="form-control select2 mr-2" name="customer_mc_ff">
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            selected="selected">MC</option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;">
                                            FF</option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;">
                                            NA</option>
                                    </select>
                                    <input class="form-control select2" name="customer_mc_ff_input"
                                        style="width: 65%;height:30px;">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address <code>*</code></label>
                                <input type="text" class="form-control select2" required="" name="customer_address"
                                    id="customer_address" style="width: 100%;height:30px;padding: 0px 0 0 10px;  ">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Country <code>*</code></label>
                                <div>
                                    <select
                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                                        class="form-control select2" required="" name="customer_country" id="country">
                                        <option
                                            style="font-family: Poppins, sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: rgb(102, 102, 102); display: none;"
                                            selected="selected" class="hiddenOption">
                                            Choose Country
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="233">United States
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="39">Canada
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="1">Afghanistan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="2">Aland Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="3">Albania
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="4">Algeria
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="5">American Samoa
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="6">Andorra
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="7">Angola
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="8">Anguilla
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="9">Antarctica
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="10">Antigua And Barbuda
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="11">Argentina
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="12">Armenia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="13">Aruba
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="14">Australia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="15">Austria
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="16">Azerbaijan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="18">Bahrain
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="19">Bangladesh
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="20">Barbados
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="21">Belarus
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="22">Belgium
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="23">Belize
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="24">Benin
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="25">Bermuda
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="26">Bhutan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="27">Bolivia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="155">Bonaire, Sint Eustatius and Saba
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="28">Bosnia and Herzegovina
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="29">Botswana
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="30">Bouvet Island
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="31">Brazil
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="32">British Indian Ocean Territory
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="33">Brunei
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="34">Bulgaria
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="35">Burkina Faso
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="36">Burundi
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="37">Cambodia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="38">Cameroon
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="40">Cape Verde
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="41">Cayman Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="42">Central African Republic
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="43">Chad
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="44">Chile
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="45">China
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="46">Christmas Island
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="47">Cocos (Keeling) Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="48">Colombia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="49">Comoros
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="50">Congo
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="52">Cook Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="53">Costa Rica
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="54">Cote D'Ivoire (Ivory Coast)
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="55">Croatia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="56">Cuba
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="249">Curaçao
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="57">Cyprus
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="58">Czech Republic
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="51">Democratic Republic of the Congo
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="59">Denmark
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="60">Djibouti
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="61">Dominica
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="62">Dominican Republic
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="63">East Timor
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="64">Ecuador
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="65">Egypt
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="66">El Salvador
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="67">Equatorial Guinea
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="68">Eritrea
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="69">Estonia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="70">Ethiopia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="71">Falkland Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="72">Faroe Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="73">Fiji Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="74">Finland
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="75">France
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="76">French Guiana
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="77">French Polynesia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="78">French Southern Territories
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="79">Gabon
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="80">Gambia The
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="81">Georgia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="82">Germany
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="83">Ghana
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="84">Gibraltar
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="85">Greece
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="86">Greenland
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="87">Grenada
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="88">Guadeloupe
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="89">Guam
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="90">Guatemala
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="91">Guernsey and Alderney
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="92">Guinea
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="93">Guinea-Bissau
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="94">Guyana
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="95">Haiti
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="96">Heard Island and McDonald Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="97">Honduras
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="98">Hong Kong S.A.R.
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="99">Hungary
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="100">Iceland
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="101">India
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="102">Indonesia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="103">Iran
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="104">Iraq
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="105">Ireland
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="106">Israel
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="107">Italy
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="108">Jamaica
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="109">Japan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="110">Jersey
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="111">Jordan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="112">Kazakhstan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="113">Kenya
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="114">Kiribati
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="248">Kosovo
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="117">Kuwait
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="118">Kyrgyzstan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="119">Laos
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="120">Latvia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="121">Lebanon
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="122">Lesotho
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="123">Liberia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="124">Libya
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="125">Liechtenstein
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="126">Lithuania
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="127">Luxembourg
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="128">Macau S.A.R.
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="130">Madagascar
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="131">Malawi
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="132">Malaysia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="133">Maldives
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="134">Mali
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="135">Malta
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="136">Man (Isle of)
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="137">Marshall Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="138">Martinique
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="139">Mauritania
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="140">Mauritius
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="141">Mayotte
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="142">Mexico
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="143">Micronesia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="144">Moldova
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="145">Monaco
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="146">Mongolia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="147">Montenegro
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="148">Montserrat
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="149">Morocco
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="150">Mozambique
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="151">Myanmar
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="152">Namibia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="153">Nauru
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="154">Nepal
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="156">Netherlands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="157">New Caledonia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="158">New Zealand
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="159">Nicaragua
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="160">Niger
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="161">Nigeria
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="162">Niue
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="163">Norfolk Island
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="115">North Korea
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="129">North Macedonia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="164">Northern Mariana Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="165">Norway
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="166">Oman
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="167">Pakistan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="168">Palau
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="169">Palestinian Territory Occupied
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="170">Panama
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="171">Papua new Guinea
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="172">Paraguay
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="173">Peru
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="174">Philippines
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="175">Pitcairn Island
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="176">Poland
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="177">Portugal
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="178">Puerto Rico
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="179">Qatar
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="180">Reunion
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="181">Romania
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="182">Russia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="183">Rwanda
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="184">Saint Helena
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="185">Saint Kitts And Nevis
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="186">Saint Lucia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="187">Saint Pierre and Miquelon
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="188">Saint Vincent And The Grenadines
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="189">Saint-Barthelemy
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="190">Saint-Martin (French part)
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="191">Samoa
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="192">San Marino
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="193">Sao Tome and Principe
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="194">Saudi Arabia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="195">Senegal
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="196">Serbia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="197">Seychelles
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="198">Sierra Leone
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="199">Singapore
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="250">Sint Maarten (Dutch part)
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="200">Slovakia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="201">Slovenia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="202">Solomon Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="203">Somalia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="204">South Africa
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="205">South Georgia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="116">South Korea
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="206">South Sudan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="207">Spain
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="208">Sri Lanka
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="209">Sudan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="210">Suriname
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="211">Svalbard And Jan Mayen Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="212">Swaziland
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="213">Sweden
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="214">Switzerland
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="215">Syria
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="216">Taiwan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="217">Tajikistan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="218">Tanzania
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="219">Thailand
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="17">The Bahamas
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="220">Togo
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="221">Tokelau
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="222">Tonga
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="223">Trinidad And Tobago
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="224">Tunisia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="225">Turkey
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="226">Turkmenistan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="227">Turks And Caicos Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="228">Tuvalu
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="229">Uganda
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="230">Ukraine
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="231">United Arab Emirates
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="232">United Kingdom
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="234">United States Minor Outlying Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="235">Uruguay
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="236">Uzbekistan
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="237">Vanuatu
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="238">Vatican City State (Holy See)
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="239">Venezuela
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="240">Vietnam
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="241">Virgin Islands (British)
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="242">Virgin Islands (US)
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="243">Wallis And Futuna Islands
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="244">Western Sahara
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="245">Yemen
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="246">Zambia
                                        </option>
                                        <option
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                            value="247">Zimbabwe
                                        </option>
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
                                        class="form-control select2" required="" name="customer_state" id="state"
                                        disabled="">
                                        <option value="" disabled="" selected="">Choose States</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>City <code>*</code></label>
                                <input type="text" class="form-control select2" required="" name="customer_city"
                                    id="customer_city" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Zip <code>*</code></label>
                                <input type="number" class="form-control select2" required="" name="customer_zip"
                                    id="customer_zip" style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <div class="form-group d-flex align-items-center">
                                <label class="one-line-label"
                                    style="white-space: nowrap;margin-right: 27px;margin-bottom: 11px;">Same as Physical
                                    Address</label>
                                <input class="form-control select2" type="checkbox" name="same_as_physical"
                                    id="same_as_physical"
                                    style="width: 15px;height: 30px;margin-top: 12px;margin-bottom: 17px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Billing Address <code>*</code></label>
                                <input type="text" class="form-control select2" required=""
                                    name="customer_billing_address" id="customer_billing_address"
                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Billing City <code>*</code></label>
                                <input type="text" class="form-control select2" required="" name="customer_billing_city"
                                    id="customer_billing_city" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Billing State <code>*</code></label>
                                <input type="text" class="form-control select2" required=""
                                    name="customer_billing_state" id="customer_billing_state"
                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Billing Zip <code>*</code></label>
                                <input type="number" class="form-control select2" required=""
                                    name="customer_billing_zip" id="customer_billing_zip"
                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Billing Country <code>*</code></label>
                                <input type="text" class="form-control select2" required=""
                                    name="customer_billing_country" id="customer_billing_country"
                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>POC Name<code>*</code></label>
                                <input type="text" class="form-control select2" required=""
                                    name="customer_primary_contact"
                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telephone <code>*</code></label>
                                <input type="number" maxlimit="12" class="form-control select2" required=""
                                    name="customer_telephone" id="customer_telephone"
                                    placeholder="Special Character Are Not Allowed"
                                    style="width: 100%; height: 30px; padding: 0px 0 0 10px;">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Extn. </label>
                                <input type="text" class="form-control select2" name="customer_extn"
                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email <code>*</code></label>
                                <input type="email" class="form-control select2" required="" name="customer_email"
                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="form-group">
                                <label>Website URL </label>
                                <input class="form-control select2" name="adv_customer_webiste_url"
                                    id="adv_customer_webiste_url"
                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fax</label>
                                <input type="text" class="form-control select2" name="customer_fax"
                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Acc Pay Email <code>*</code></label>
                                <input type="email" class="form-control select2" name="customer_secondary_email"
                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; " required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>AP Contact</label>
                                <input type="number" class="form-control select2" name="customer_billing_telephone"
                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Extn.</label>
                                <input type="text" class="form-control select2" name="customer_billing_extn"
                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group align-items-center">
                                <label class="mr-2">Status <code>*</code></label>
                                <div>
                                    <select
                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px; "
                                        class="form-control select2" required="" name="customer_status">
                                        <option
                                            style="font-family: Poppins, sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: rgb(102, 102, 102); display: none;"
                                            selected="selected" class="hiddenOption">
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
                    <div class="modal-title">
                        <h3 class="card-title head">ADVANCED</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Currency Setting <code>*</code></label>
                                <div class="d-flex" style="width: 100%; height: 30px;">
                                    <select class="form-control select2 mr-2"
                                        style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666; width: 100%; height: 30px;"
                                        name="adv_customer_currency_Setting">
                                        <option selected="selected"
                                            style="font-family: Poppins, sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: rgb(102, 102, 102); display: none;"
                                            class="hiddenOption">Please Select
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
                                <label>Payment Terms <code>*</code></label>
                                <div class="d-flex" style="width: 100%;  ">
                                    <div class="d-flex" style="width: 100%;  ">
                                        <select class="form-control select2" name="adv_customer_payment_terms"
                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;height:30px"
                                            onchange="showInput()">
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
                                        <input class="form-control select2" name="adv_customer_payment_terms_custome"
                                            style="width: 100%; height: 30px; display: none;" id="custome_input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Credit Limits <code>*</code></label>
                                <input class="form-control select2" type="number" required=""
                                    name="adv_customer_credit_limit"
                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sales Rep. <code>*</code></label>
                                <input type="text" class="form-control select2" name="adv_customer_sales_rep"
                                    value="Niku" readonly="" style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-1 el_min100">Duplicate</label>
                                <div class="check d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="AddAsShipper"
                                            name="AddAsShipper">
                                        <span class="form-check-label" for="AddAsShipper" style="font-size:15px;">Add
                                            as Shipper</span>
                                    </div>
                                    <div class="form-check" style="margin: 3px 0 0 16px;">
                                        <input class="form-check-input" type="checkbox" id="AddAsConsignee"
                                            name="AddAsConsignee">
                                        <span class="form-check-label" for="AddAsConsignee" style="font-size:15px;">Add
                                            as Consignee</span>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group align-items-center">
                                <label style="line-height: 1.2em;">Internal Notes </label>
                                <textarea class=" select2 mt-3" type="text" name="adv_customer_internal_notes"
                                    id="adv_customer_internal_notes"
                                    style="width: 100%; height:70px;border:1px solid #ccc"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="line-height: 1.2em;">Upload files</label>
                                <p>Please upload the file you want to share</p>
                                <label for="upload" class="upload-button text-center w-100">
                                    <input type="file" id="upload" multiple="">
                                    <p class="choose-file">Choose the file</p>
                                </label>
                            </div>
                        </div>
                    </div>



                    <div class="modal-footer align-item-center justify-content-center">
                        <!-- <input type="submit" class="btn btn-info" value="Add"> -->
                        <button type="submit" class="btn btn-info">Update</button>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- CUSTOMER DETAILS popup end -->

<!-- Add Shipper popup start -->
<div class="modal" id="add-shipper">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0 m-0">
                <h4 class="modal-title">Add Shipper</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <form>
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Name <code>*</code></label>
                                    <input type="text" class="form-control" name="shipper_name">
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="shipper_address">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Country <code>*</code></label>
                                    <div>
                                        <select>
                                            <option>United State</option>
                                            <option>Canada</option>
                                            <option>Albania</option>
                                            <option>Algeria</option>
                                            <option>American Samroa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>State <code>*</code></label>
                                    <div>
                                        <select>
                                            <option>Albama</option>
                                            <option>Alaska</option>
                                            <option>California</option>
                                            <option>Guam</option>
                                            <option>Hawai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>City <code>*</code></label>
                                    <input type="text" class="form-control select2" required name="customer_city">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Zip <code>*</code></label>
                                    <input type="number" class="form-control select2" required name="customer_zip">
                                </div>
                            </div>



                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Contact Name</label>
                                    <input type="text" class="form-control" name="shipper_contact_name">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Contact Email</label>
                                    <input type="email" class="form-control" name="shipper_contact_email">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Telephone <code>*</code></label>
                                    <input type="number" class="form-control" name="shipper_telephone">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Ext. </label>
                                    <input type="text" class="form-control" name="shipper_extn">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label>Toll Free</label>
                                    <input type="number" class="form-control" name="shipper_toll_free">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input type="text" class="form-control" name="shipper_fax">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Shipping Hours</label>
                                    <input type="time" class="form-control" name="shipper_hours">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Appointments</label>
                                    <select class="form-control select2" name="shipper_appointments">
                                        <option selected="selected">Select</option>
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>Major Intersections</label>
                                    <input type="text" class="form-control" name="shipper_major_intersections">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="col-12 col-sm-3">
                                    <div class="form-group d-flex align-items-center">
                                        <input class="form-control" type="checkbox" name="same_as_consignee">
                                        <label class="one-line-label mr-2" style="white-space: nowrap;">Add as
                                            consignee</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>Status <code>*</code></label>
                                    <select class="form-control select2" name="shipper_status">
                                        <option selected="selected">Select</option>
                                        <option>Active</option>
                                        <option>In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Shipping Notes </label>
                                    <textarea class="form-control" name="shipper_shipping_notes"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Internal Notes </label>
                                    <textarea class="form-control" name="shipper_internal_notes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center align-item-center">
                        <input type="submit" class="btn btn-info" value="Add">
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Shipper popup end -->

<!-- Add consignee popup start -->

<div class="modal" id="add-consignee">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0 m-0">
                <h4 class="modal-title">Add Consignee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <form>
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Name <code>*</code></label>
                                    <input class="form-control" name="consignee_name">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Address </label>
                                    <input class="form-control" name="consignee_address">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Country <code>*</code></label>
                                    <div>
                                        <select>
                                            <option>United State</option>
                                            <option>Canada</option>
                                            <option>Albania</option>
                                            <option>Algeria</option>
                                            <option>American Samroa</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>State <code>*</code></label>
                                    <div>
                                        <select>
                                            <option>Albama</option>
                                            <option>Alaska</option>
                                            <option>California</option>
                                            <option>Guam</option>
                                            <option>Hawai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>City <code>*</code></label>
                                    <input class="form-control" name="consignee_city">
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Zip <code>*</code></label>
                                    <input type="number" class="form-control" name="consignee_zip">
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Major Intersections</label>
                                    <input class="form-control" name="consignee_major_intersections">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status <code>*</code></label>
                                    <select class="form-control" name="consignee_status">
                                        <option selected="selected">Select Status
                                        </option>
                                        <option value="Active">Active</option>
                                        <option value="In-Active">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input class="form-control" name="consignee_contact_name">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Contact Email</label>
                                    <input class="form-control" name="consignee_contact_email">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Telephone <code>*</code></label>
                                    <input type="number" class="form-control" name="consignee_telephone">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Ext. </label>
                                    <input type="text" class="form-control" name="consignee_ext">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Toll Free</label>
                                    <input class="form-control" name="consignee_toll_free">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input class="form-control" name="consignee_fax">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Consignee Hours</label>
                                    <input type="time" class="form-control" name="consignee_hours">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Appointments</label>
                                    <select class="form-control select2" name="consignee_appointments">
                                        <option selected="selected">Please Select
                                        </option>
                                        <option>No</option>
                                        <option>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                            <div class="col-md-4 col-sm-6">
                                <div class="col-12 col-sm-3">
                                    <div class="form-group d-flex align-items-center">
                                        <label class="one-line-label mr-2" style="white-space: nowrap;">Add as
                                            Shipper</label>
                                        <input class="form-control" type="checkbox" name="consignee_add_shippper">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Internal Notes </label>
                                    <textarea class="form-control" name="consignee_internal_notes"
                                        style="width: 100%;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Shipping Notes </label>
                                    <textarea class="form-control" name="consignee_shipping_notes"
                                        style="width: 100%;"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Assuming you are in a Blade view file (e.g., create.blade.php) -->
                        <input type="text" name="added_by_user">

                    </div>
                    <div class="modal-footer align-item-center justify-content-ceneter">
                        <input type="submit" class="btn btn-info">
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>


<!-- Your Modal HTML -->
<div class="modal" id="customMailModal">
    <div class="modal-dialog">
        <!-- Modal content -->
        <form id="mailForm" enctype="multipart/form-data" action="{{ route('send.invoice.email') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header" style="padding: 0 21px;">
                    <h4 class="modal-title" style="background:unset;color: #000; font-weight: 700;">Send Custom Email</h4>
                    <button type="button" style="top: 29px !important;color: #fff;" class="close"
                        data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="toEmail">To:</label>
                        <input type="text" class="form-control" id="toEmail" name="toEmail"
                            placeholder="Enter recipient email" required>
                        <small id="toEmailHelp" class="form-text text-muted">Separate multiple emails with commas
                            (,)</small>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="attachments">Attachment:</label>
                        <i id="uploadIcon" class="fa fa-upload" style="cursor: pointer;"></i>
                        <input type="file" class="form-control-file d-none" id="attachments" name="attachments[]"
                            multiple>
                        <div id="selectedFiles"></div> <!-- Display selected files -->
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter message"
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="background-color: #ee2558;color: #fff;" class="btn btn-danger"
                        data-dismiss="modal">Close</button>
                    <button type="button" id="sendMailBtn" class="btn btn-info">Send</button>
                </div>
            </div>
        </form>


    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    function printPreInvoice(id) {
        var printWindow = window.open('/print-invoice/' + id, '_blank', 'width=800,height=600');
        printWindow.focus();
        printWindow.onload = function () {
            printWindow.print();
        };
    }
</script>


<script>
    function printInvoice(recordId) {
        var printWindow = window.open('/invoices/' + recordId + '/print/paid', '_blank', 'width=800,height=600');
        printWindow.addEventListener('load', function () {
            printWindow.print();
        }, true);
    }
</script>
<script>
    $(document).ready(function () {
        var selectedFiles = []; // Array to store selected files

        // Handle file input change event
        $('#attachments').on('change', function () {
            var newFiles = $(this).prop('files');
            addSelectedFiles(newFiles); // Add newly selected files to selectedFiles array
            displaySelectedFiles(); // Display all selected files
        });

        // Function to add selected files to selectedFiles array
        function addSelectedFiles(newFiles) {
            if (newFiles.length > 0) {
                // Append new files to selectedFiles array
                $.each(newFiles, function (index, file) {
                    selectedFiles.push(file);
                });
            }
        }

        // Function to display selected files
        function displaySelectedFiles() {
            $('#selectedFiles').empty(); // Clear previous selections

            if (selectedFiles.length > 0) {
                // Display all selected file names
                $.each(selectedFiles, function (index, file) {
                    $('#selectedFiles').append('<div>' + file.name +
                        ' <span class="deleteFile" data-index="' + index + '">&times;</span></div>');
                });

                // Handle click on delete icon
                $('.deleteFile').on('click', function () {
                    var index = $(this).data('index');
                    selectedFiles.splice(index, 1); // Remove file from selectedFiles array
                    displaySelectedFiles(); // Update displayed files
                });
            }
        }

        // Handle form submission
        $('#sendMailBtn').on('click', function () {
            var formData = new FormData($('#mailForm')[0]);

            // Append all selected files to formData
            $.each(selectedFiles, function (index, file) {
                formData.append('attachments[]', file);
            });

            // Send AJAX request to send email
            $.ajax({
                url: '{{ route("send.invoice.email") }}',
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    if (response.success) {
                        alert(response.message); // Show success message
                        $('#mailForm')[0].reset(); // Reset form
                        $('#selectedFiles').empty(); // Clear selected files display
                        selectedFiles = []; // Clear selected files array
                    } else {
                        alert('Error: ' + response.message); // Show error message
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('AJAX Error: ' + xhr.responseText); // Show AJAX error message
                }
            });
        });

        // Trigger file input click on icon click
        $('#uploadIcon').on('click', function () {
            $('#attachments').click();
        });
    });
</script>

<script>
    $(document).ready(function () {
        function updateRemainingAmount(invoiceId) {
            var shipperLoadFinalRate = parseFloat($('#receiving_amount_' + invoiceId).data(
                'shipper-load-final-rate'));
            var receivingAmount = parseFloat($('#receiving_amount_' + invoiceId).val()) || 0;
            var remainingAmount = shipperLoadFinalRate - receivingAmount;

            // Ensure remaining amount is not negative
            remainingAmount = Math.max(remainingAmount, 0);

            // Display remaining amount, limiting to 2 decimal places
            $('#remaining_amount_' + invoiceId).val(remainingAmount.toFixed(2));
        }

        function saveReceivingAmount(invoiceId) {
            var receivingAmount = parseFloat($('#receiving_amount_' + invoiceId).val()) || 0;
            var remainingAmount = parseFloat($('#remaining_amount_' + invoiceId).val()) || 0;

            $.ajax({
                url: '{{ route("load.updateReceivingAmount") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    load_id: invoiceId,
                    receiving_amount: receivingAmount,
                    remaining_amount: remainingAmount
                },
                success: function (response) {
                    if (response.success) {
                        $('#remaining_amount_' + invoiceId).val(response.remaining_amount);
                    } else {
                        alert('Failed to update receiving amount');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert('An error occurred while updating the receiving amount');
                }
            });
        }

        $(document).on('input', '.receiving_amount', function () {
            var invoiceId = $(this).data('invoice-id');
            updateRemainingAmount(invoiceId);
        });

        $(document).on('change', '.receiving_amount', function () {
            var invoiceId = $(this).data('invoice-id');
            updateRemainingAmount(invoiceId);
            saveReceivingAmount(invoiceId);
        });
    });
</script>


<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js">
</script>



<script>
        function markAsPaid(loadId) {
            axios.post(`/update-invoice-status/${loadId}`, {
                    status: 'Paid'
                })
                .then(response => {
                    const button = document.getElementById(`markAsPaidBtn_${loadId}`);
                    button.textContent = 'Paid';
                    button.className = 'btn btn-success btn-sm';
                    button.disabled = true;

                    alert(response.data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to mark as Paid.');
                });
        }
    </script>
    <script>
        function markAsPaid(loadId) {
            if (confirm('By Continuing, an Invoice Number Will be assigned to this Load. Are You sure to Continue')) {
                axios.post(`/update-invoice-status/${loadId}`, {
                        status: 'Paid'
                    })
                    .then(response => {
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error marking as Paid:', error);
                        alert('Failed to mark as Paid.');
                    });
            }
        }
    </script>


    <script>
        function markAsCompleted(loadId) {
            console.log('Inside markAsCompleted function');

            if (confirm('Are you sure you want to mark this as Completed?')) {
                axios.post(`/update-invoice-status-as-completed/${loadId}`, {
                        status: 'Completed'
                    })
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error marking as Completed:', error);
                        alert('Failed to mark as Completed.');
                    });
            }
        }
    </script>

    <script>
        function markAsPaidRecord(loadId) {
            console.log('Inside markAsPaidRecord function');

            if (confirm('Are you sure you want to mark this as Invoiced ?')) {
                axios.post(`/update-invoice-status-as-paid-record/${loadId}`, {
                        status: 'Paid Record',
                        _token: '{{ csrf_token() }}'
                    })
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error marking as Paid Record:', error);
                        alert('Failed to mark as Paid Record.');
                    });
            }
        }
    </script>


    <script>
        function openLoad(loadId) {
            if (confirm('Are you sure you want to mark this as Open?')) {
                axios.put(`/update-load-status-as-open/${loadId}`)
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload(); // Reload the page after successful update
                    })
                    .catch(error => {
                        console.error('Error marking as Open:', error);
                        alert('Failed to mark as Open.');
                    });
            }
        }
    </script>


    <script>
        function markAsBackDeliveredRecord(loadId) {
            if (confirm('Are you sure you want to back this record in Delivered?')) {
                axios.put(`/update-invoice-status-as-back-delivered/${loadId}`)
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload(); // Reload the page after successful update
                    })
                    .catch(error => {
                        console.error('Error marking as Back to Deliver:', error);
                        alert('Failed to back in deliver.');
                    });
            }
        }
    </script>

    <script>
        function markAsBackCompleteRecord(loadId) {
            if (confirm('Are you sure you want to back this record in Complete')) {
                axios.post(`/update-invoice-status-as-back-complete/${loadId}`)
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error marking as Back to Complete:', error);
                        alert('Failed back in deliver.');
                    });
            }
        }
    </script>

    <script>
        function markAsBackInvoiceRecord(loadId) {
            if (confirm('Are you sure you want to back this record in Invoice?')) {
                axios.post(`/update-invoice-status-as-back-invoice/${loadId}`)
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error marking as Back to Invoice:', error);
                        alert('Failed back in Invoice.');
                    });
            }
        }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manager Filter
        document.getElementById('manager').addEventListener('change', function() {
            var managerFilterValue = this.value.toLowerCase();
            var rows = document.querySelectorAll('#dataTable tbody tr');

            rows.forEach(function(row) {
                var manager = row.querySelector('.manager-column').textContent.toLowerCase();

                if (managerFilterValue === "" || manager.includes(managerFilterValue)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        // Team Lead Filter
        document.getElementById('team_lead').addEventListener('change', function() {
            var teamLeadFilterValue = this.value.toLowerCase();
            var rows = document.querySelectorAll('#dataTable tbody tr');

            rows.forEach(function(row) {
                var teamLead = row.querySelector('.tl-column').textContent.toLowerCase();

                if (teamLeadFilterValue === "" || teamLead.includes(teamLeadFilterValue)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });


        
    });
</script>
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