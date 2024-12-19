@extends('layouts.accounts.app')
@section('content')

<style>
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

    .modal button.close {
        position: absolute;
        right: 8px;
        top: 0px;
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
</style>
<section class="content">
    <div class="body_scroll">
        <!-- Tabs With Icon Title -->
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="card">
                    <div class="block-header">
                        <h2>Accounting Data Management</h2>
                    </div>
                    <div class="container-fluid">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist" id="myTab">
                            <li class="nav-item "><a class="nav-link active" data-toggle="tab" style="font-size:15px;"
                                    href="#home_with_icon_title">
                                    <i class="fas fa-shipping-fast"></i> Delivered</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" style="font-size:15px;"
                                    href="#profile_with_icon_title"><i class="fa fa-check" aria-hidden="true"></i>
                                    Completed </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" style="font-size:15px;"
                                    href="#messages_with_icon_title"><i class="zmdi zmdi-email"></i> Invoiced </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" style="font-size:15px;"
                                    href="#settings_with_icon_title"><i class="fas fa-wallet"></i> Invoiced / Paid
                                </a></li>
                        </ul>



                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active col-12 p-0" id="home_with_icon_title">
                                <div class="body p-0">
                                    <div class="table-responsive">
                                        <div class="col-md-12 text-center date-time">
                                            <div class="date">
                                                <label for="start">Start Date</label>
                                                <input id="start" class="start_filter filter-dropdown"
                                                    style="height: 30px;color: #3e3e40;" type="date" />
                                            </div>
                                            <div class="date" style="margin-left: 14px;">
                                                <label for="end">End Date</label>
                                                <input id="end" class="end_filter filter-dropdown"
                                                    style="height: 30px;color: #3e3e40;" type="date" />
                                            </div>

                                            <select name="manager" id="manager" class="manager_filter filter-dropdown"
                                                style="margin-left:7px; margin-top: 9px; height: 30px;color: #3e3e40;">
                                                <option value="" selected>Sort By Manager</option>
                                                @foreach($manager as $managers)
                                                <option value="{{ $managers->manager }}">{{ $managers->manager }}
                                                </option>
                                                @endforeach
                                            </select>

                                            <select name="team_lead" id="team_lead"
                                                class="team_lead_filter filter-dropdown"
                                                style="height: 30px;color: #3e3e40;margin-left:7px; margin-top: 9px;">
                                                <option value="" selected>Sort By TL</option>
                                                @foreach($teamlead as $teamLead)
                                                <option value="{{ $teamLead->tl }}">{{ $teamLead->tl }}</option>
                                                @endforeach
                                            </select>

                                            <select name="office" id="office" class="office_filter filter-dropdown"
                                                style="height: 30px;color: #3e3e40;margin-left:7px; margin-top: 9px;">
                                                <option value="" selected>Sort By Office</option>
                                                @foreach($office as $offices)
                                                <option value="{{ $offices->office_name }}">{{ $offices->office_name }}
                                                </option>
                                                @endforeach
                                            </select>


                                        </div>

                                        <table class="custom-table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Load #</th>
                                                    <th>W/O #</th>
                                                    <th>Customer #</th>
                                                    <th>Office</th>
                                                    <th>Manager</th>
                                                    <th>Team Leader</th>
                                                    <th>Load Create Date</th>
                                                    <th>Shipper Date</th>
                                                    <th>Delivery Date</th>
                                                    <th>Actual Delivery Date</th>
                                                    <th>Carrier</th>
                                                    <th>Pickup Location</th>
                                                    <th>Unloading Location</th>
                                                    <th>Final Del</th>
                                                    <th>Load Status</th>
                                                    <th>Aging</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = 1;
                                                @endphp
                                                @foreach($loads as $delivered)
                                                @if($delivered->load_status == 'Delivered' && $delivered->invoice_status
                                                !== 'Completed' && $delivered->invoice_status !== 'Paid' &&
                                                $delivered->invoice_status !== 'Paid Record')
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $delivered->id }}</td>
                                                    <td>{{ $delivered->load_workorder }}</td>
                                                    <td>{{ $delivered->load_bill_to }}</td>
                                                    <td>{{ $delivered->user->office }}</td>
                                                    <td>{{ $delivered->user->manager }}</td>
                                                    <td>{{ $delivered->user->team_lead }}</td>
                                                    <td>{{ $delivered->created_at }}</td>
                                                    <td>{{ $delivered->load_shipper_appointment }}</td>
                                                    <td>{{ $delivered->load_consignee_appointment }}</td>
                                                    <td>{{ $delivered->load_actual_delivery_date }}</td>
                                                    <td>{{ $delivered->load_carrier }}</td>
                                                    <td>{{ $delivered->load_shipperr }}</td>
                                                    <td>{{ $delivered->load_consignee }}</td>
                                                    <td>{{ $delivered->load_consignee }}</td>
                                                    <td>{{ $delivered->load_status }}</td>
                                                    <td class="dynamic-data">
                                                        @php
                                                        $deliveredDate = \Carbon\Carbon::parse($delivered->created_at);
                                                        $currentDate = \Carbon\Carbon::now();
                                                        $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                                        @endphp
                                                        {{ $differenceInDays }} days
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-primary dropdown-toggle pt-1 pb-1"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-71px, 41px, 0px);">
                                                                <li>
                                                                    <a id="markAsCompletedBtn_{{ $delivered->id }}"
                                                                        style="color: #777;"
                                                                        class="text-left btn btn-{{ in_array($delivered->invoice_status, ['Deliverd', 'Delivered']) ? 'success' : 'danger' }} btn-sm"
                                                                        onclick="markAsCompleted({{ $delivered->id }})">
                                                                        @if(in_array($delivered->invoice_status,
                                                                        ['Deliverd ',
                                                                        'Delivered']))
                                                                        Completed
                                                                        @else
                                                                        <i class="fa fa-check"
                                                                            style="margin-right: 10px; font-size: 19px;"
                                                                            aria-hidden="true"></i>
                                                                        @endif
                                                                        Approved</a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('accounting.load.edit', $delivered->id) }}"
                                                                        data-toggle="modal" data-target="#edit-data"
                                                                        class="btn btn-sm btn-warning text-left"><i
                                                                            class="fa fa-pen"
                                                                            style="margin-right: 10px; font-size: 19px;"></i>Edit</a>
                                                                </li>
                                                                <!-- <li>
                                                                    <a href="#"
                                                                        onclick="openLoad({{ $delivered->id }})"><i
                                                                            class="fas fa-reply"
                                                                            style="margin-right: 10px; font-size: 19px;"></i>Back</a>
                                                                </li> -->
                                                                <li>
                                                                    <a onclick="openModal({{ $delivered->id }})"
                                                                        data-toggle="modal" data-target="#view-file"><i
                                                                            class="fa fa-eye"
                                                                            style="color: #777777;margin-right: 10px; font-size: 19px;"></i>View
                                                                        Upload</a>
                                                                </li>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile_with_icon_title">
                                <div class="body p-0">
                                    <div class="table-responsive">

                                        <table class="custom-table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Load #</th>
                                                    <th>W/O #</th>
                                                    <th>Customer #</th>
                                                    <th>Office</th>
                                                    <th>Manager</th>
                                                    <th>Team Leader</th>
                                                    <th>Load Create Date</th>
                                                    <th>Shipper Date</th>
                                                    <th>Delivery Date</th>
                                                    <th>Carrier</th>
                                                    <th>Pickup Location</th>
                                                    <th>Unloading Location</th>
                                                    <th>Final Del</th>
                                                    <th>Load Status</th>
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
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $i++ }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_number }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_workorder }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_bill_to }}
                                                    </td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->user->office }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->user->manager }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->user->team_lead }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->created_at->format('m-d-y H:i:s') }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_shipper_appointment }}
                                                    </td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_consignee_appointment }}
                                                    </td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_carrier }}
                                                    </td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_shipper_location }}
                                                    </td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_consignee }}
                                                    </td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_consignee }}
                                                    </td>

                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $completed->load_status }}
                                                    </td>
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

                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-primary dropdown-toggle pt-1 pb-1"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-71px, 41px, 0px);">
                                                                <li>
                                                                    <a id="markAsPaidBtn_{{ $completed->id }}"
                                                                        style="color: #777;"
                                                                        class="text-left btn btn-{{ $completed->invoice_status === 'Paid' ? 'success' : 'danger' }} btn-sm"
                                                                        onclick="markAsPaid({{ $completed->id }})">
                                                                        @if($completed->invoice_status
                                                                        === 'Paid')
                                                                        Paid
                                                                        @else
                                                                        <i class="fa fa-check"
                                                                            style="margin-right: 10px; font-size: 19px;"
                                                                            aria-hidden="true"></i>Approved
                                                                        @endif
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('accounting.load.edit', $completed->id) }}"
                                                                        data-toggle="modal" data-target="#edit-data"
                                                                        class="text-left btn btn-sm btn-warning"><i
                                                                            class="fa fa-pen"
                                                                            style="margin-right: 10px; font-size: 19px;"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"
                                                                        onclick="markAsBackDeliveredRecord({{ $completed->id }})">
                                                                        <i class="fas fa-reply"
                                                                            style="margin-right: 10px;font-size: 19px;"></i>Back
                                                                    </a>
                                                                </li>

                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="messages_with_icon_title">
                                <div class="body p-0">
                                    <div class="table-responsive">

                                        <table class="custom-table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Load #</th>
                                                    <th>Invoice #</th>
                                                    <th>Invoice Date</th>
                                                    <th>W/O #</th>
                                                    <th>Customer #</th>
                                                    <th>Office</th>
                                                    <th>Manager</th>
                                                    <th>Team Leader</th>
                                                    <th>Load Create Date</th>
                                                    <th>Shipper Date</th>
                                                    <th>Delivery Date</th>
                                                    <th>Carrier</th>
                                                    <th>Pickup Location</th>
                                                    <th>Unloading Location</th>
                                                    <th>Final Del</th>
                                                    <th>Load Status</th>
                                                    <th>Aging</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $i=1;
                                                @endphp
                                                @foreach($loads_paid as $invoice)
                                                @if($invoice->invoice_status === 'Paid' &&
                                                $invoice->invoice_status !== 'Deliverd' &&
                                                $invoice->invoice_status !== 'Delivered' &&
                                                $invoice->invoice_status !== 'Completed')

                                                <tr>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $i++ }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_number }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->invoice_number }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ date('d-m-Y', strtotime($invoice->invoice_date)) }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_workorder }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_bill_to }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->user->office }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->user->manager }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->user->team_lead }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->created_at }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_shipper_appointment }}</td>

                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_consignee_appointment }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_carrier }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_shipper_location }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_consignee_location }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_consignee }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $invoice->load_status }}</td>
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
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-primary dropdown-toggle pt-1 pb-1"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-71px, 41px, 0px);">
                                                                <li>
                                                                    <a id="markAsPaidRecordBtn_{{ $invoice->id }}"
                                                                        style="color: #777;"
                                                                        class="text-left btn btn-{{ $invoice->invoice_status === 'Paid Record' ? 'success' : 'danger' }} btn-sm"
                                                                        onclick="markAsPaidRecord({{ $invoice->id }})"><i
                                                                            class="fa fa-check"
                                                                            style="margin-right: 10px;font-size: 19px;"
                                                                            aria-hidden="true"></i>Mark as Paid
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('accounting.load.edit', $delivered->id) }}"
                                                                        data-toggle="modal" data-target="#edit-data"
                                                                        class="text-left btn btn-sm btn-warning"><i
                                                                            class="fa fa-pen"
                                                                            style="margin-right: 10px;font-size: 19px;"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a class="text-left" href="#"
                                                                        onclick="markAsBackCompleteRecord({{ $invoice->id }})">
                                                                        <i class="fas fa-reply"
                                                                            style="margin-right: 10px;font-size: 19px;"></i>Back
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="text-left btn btn-primary"
                                                                        data-toggle="modal"
                                                                        data-target="#customMailModal"
                                                                        style="background-color: unset;color: #555;">
                                                                        <i class="fas fa-envelope-open"
                                                                            style="margin-right: 10px;font-size: 19px;"></i>Send
                                                                        Email
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="printPreInvoice({{ $invoice->id }})">
                                                                        <i class="fa fa-print"
                                                                            style="margin-right: 10px;font-size: 19px;"></i>Print
                                                                        Invoice
                                                                    </a>
                                                                </li>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="settings_with_icon_title">
                                <div class="body p-0">
                                    <div class="table-responsive">

                                        <table class="custom-table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Load #</th>
                                                    <th>Invoice #</th>
                                                    <th>Invoice Date</th>
                                                    <th>W/O #</th>
                                                    <th>Customer #</th>
                                                    <th>Office</th>
                                                    <th>Manager</th>
                                                    <th>Team Leader</th>
                                                    <th>Load Create Date</th>
                                                    <th>Shipper Date</th>
                                                    <th>Delivery Date</th>
                                                    <th>Carrier</th>
                                                    <th>Pickup Location</th>
                                                    <th>Unloading Location</th>
                                                    <th>Final Del</th>
                                                    <th>Load Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $i=1;
                                                @endphp
                                                @foreach($loads_paid_record as $record)
                                                <tr>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $i++ }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->load_number }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->invoice_number }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->invoice_date }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record-> load_workorder }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record-> load_bill_to }}
                                                    </td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record-> user->office }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record-> user->manager }}</td>

                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record-> user->team_lead }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->created_at }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->load_shipper_appointment }}</td>

                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->load_consignee_appointment }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->load_carrier }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->load_shipper_location }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->load_consignee_location }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->load_consignee }}</td>
                                                    <td
                                                        style="padding: 7px 10px !important; vertical-align: middle !important;">
                                                        {{ $record->load_status }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-primary dropdown-toggle pt-1 pb-1"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-71px, 41px, 0px);">

                                                                <li>
                                                                    <a href="{{ route('accounting.load.edit', $delivered->id) }}"
                                                                        data-toggle="modal" data-target="#edit-data"
                                                                        class="text-left btn btn-sm btn-warning"><i
                                                                            class="fa fa-pen"
                                                                            style="margin-right: 10px;font-size: 19px;"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"
                                                                        class="text-left btn btn-sm btn-warning"><i
                                                                            class="fas fa-dollar-sign"
                                                                            style="margin-right: 10px;font-size: 19px;"></i>Paid</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="markAsBackInvoiceRecord({{ $record->id }})">
                                                                        <i class="fas fa-reply"
                                                                            style="margin-right: 10px;font-size: 19px;"></i>Mark
                                                                        as unpaid
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="printInvoice({{ $record->id }})">
                                                                        <i class="fa fa-print"
                                                                            style="margin-right: 10px;font-size: 19px;"></i>Print
                                                                        Invoice
                                                                    </a>
                                                                </li>
                                                            </div>
                                                        </div>
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



<!-- file view popup end -->
<!-- edit-data popup start -->
<div class="modal" id="edit-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0 m-0">
                <h4 class="modal-title">Edit Load</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <form action="{{ route('accounting.update.load', ['id' => $delivered->id]) }}" method="POST">
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Load Number <code>*</code></label>
                                    <input class="form-control" name="load_number"
                                        value="{{ $delivered->load_number }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Bill To <code>*</code>&nbsp;<a href="#" data-toggle="modal"
                                            data-target="#customer-detail" style="color:#0c7ce6"><i
                                                class="fa fa-plus"></i> Add New</a>
                                    </label>

                                    <input type="text" id="load_bill_to" name="load_bill_to" class="form-control"
                                        value="{{ $delivered->load_bill_to }}" placeholder="Search Customer names...">
                                    <textarea id="customerList" class="form-control" style="display: none;"
                                        readonly></textarea>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dispatcher <code>*</code></label>
                                    <input class="form-control" name="load_dispatcher"
                                        value="{{ $delivered->load_dispatcher }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2" name="load_status">
                                        <option Selected value="{{ $delivered->load_status }}">
                                            {{ $delivered->load_status }}</option>
                                        <option>Open</option>
                                        <option value="Covered">Covered</option>
                                        <option value="Dispatched">Dispatched</option>
                                        <option value="Loading">Loading</option>
                                        <option value="On Route">On Route</option>
                                        <option value="Un loading">Un loading</option>
                                        <option value="completed">Delivered</option>
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
                                        value="{{ $delivered->load_workorder }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Payment Type <code>*</code></label>
                                    <select class="form-control select2" required name="load_payment_type">
                                        <option selected value="{{ $delivered->load_payment_type }}">
                                            {{ $delivered->load_payment_type }}</option>
                                        <option>Prepaid</option>
                                        <option>Postpaid</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Type <code>*</code></label>
                                    <input class="form-control" required name="load_type"
                                        value="{{ $delivered->load_type }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Shipper Rate <code>*</code></label>
                                    <input type="number" class="form-control number value" name="load_shipper_rate"
                                        value="{{ $delivered->load_shipper_rate }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>P/D s</label>
                                    <input class="form-control" name="load_pds" type="number"
                                        value="{{ $delivered->load_pds }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>F.S.C Rate % <input type="checkbox" name="calculate_fsc_percentage"></label>
                                    <input class="form-control number percent" name="load_fsc_rate"
                                        value="{{ $delivered->load_fsc_rate }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Telephone <code>*</code></label>
                                    <input class="form-control" name="load_telephone"
                                        value="{{ $delivered->load_telephone }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label class="other_charge">Other Change &nbsp; <i class="fa fa-plus"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Final Shipper Rate</label>
                                    <input class="form-control result" name="shipper_load_final_rate"
                                        value="{{ $delivered->shipper_load_final_rate }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Carrier <code>*</code></label>
                                    <input type="text" name="load_carrier" class="form-control"
                                        placeholder="Search carrier names..." value="{{ $delivered->load_carrier }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Advance Payment</label>
                                    <input class="form-control" name="load_advance_payment"
                                        value="{{ $delivered->load_advance_payment }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Load type</label>
                                    <div class="select2-purple">
                                        <select class="form-control select2" name="load_type_two">
                                            <option value="{{ $delivered->load_type_two }}">
                                                {{ $delivered->load_type_two }}</option>
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
                                    <select class="form-control select2" name="load_billing_type">
                                        <option selected value="{{ $delivered->load_billing_type }}">
                                            {{ $delivered->load_billing_type }}</option>
                                        <option>Factoring</option>
                                        <option>Direct Billing</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>MC No <code>*</code></label>
                                    <input class="form-control" required name="load_mc_no"
                                        value="{{ $delivered->load_mc_no }}" placeholder="Enter MC Number">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Equipment Type <code>*</code></label>
                                    <select class="form-control select2" required name="load_equipment_type">
                                        <option selected value="{{ $delivered->load_equipment_type }}">
                                            {{ $delivered->load_equipment_type }}</option>
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
                                        value="{{ $delivered->load_carrier_fee }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select class="form-control select2" name="load_currency">
                                        <option value="{{ $delivered->load_currency }}">{{ $delivered->load_currency }}
                                        </option>
                                        <option>$</option>
                                        <option>%</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>P/D s <code>*</code></label>
                                    <input class="form-control" name="load_pds_two"
                                        value="{{ $delivered->load_pds_two }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>FSC Rate %</label>
                                    <input type="text" name="load_billing_fsc_rate" id="load_billing_fsc_rate"
                                        class="form-control" value="{{ $delivered->load_billing_fsc_rate }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="other_charge">Other Charges <i class="fa fa-plus"
                                            id="openModalIcon"></i></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                    <label>Final Carrier Fee</label>
                                    <input class="form-control" readonly name="load_final_carrier_fee"
                                        id="load_final_carrier_fee" value="{{ $delivered->load_final_carrier_fee }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                    <label>Dilevery Order</label>
                                    <input class="form-control" type="file" readonly name="load_delivery_do_file"
                                        id="load_delivery_do_file" value="{{ $delivered->load_final_carrier_fee }}">
                                </div>
                            </div>

                        </div>
                    </div>
                    <h4 class="modal-title">Shipper</h4>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Shipper <code>*</code> <a style="color:#0c7ce6" data-toggle="modal"
                                            data-target="#add-shipper">Add New</a></label>
                                    <input class="form-control" name="load_shipper"
                                        value="{{ $delivered->load_shipper }}">
                                    <ul id="shipperList" class="list-group" style="display: none;">
                                        <li class="list-group-item active" style="cursor: pointer; width: 100%;"></li>
                                    </ul>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input class="form-control" name="load_shipper_location"
                                        value="{{ $delivered->load_shipper_location }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date And Time<code>*</code></label>
                                    <input class="form-control" type="datetime-local" name="load_shipper_appointment"
                                        value="{{ $delivered->load_shipper_appointment }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input class="form-control" name="load_shipper_discription"
                                        value="{{ $delivered->load_shipper_discription }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Commodity Type</label>
                                    <input class="form-control select2" name="load_shipper_commodity_type"
                                        value="{{ $delivered->load_shipper_commodity_type}}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input class="form-control" name="load_shipper_qty"
                                        value="{{ $delivered->load_shipper_qty }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Weight (lbs)</label>
                                    <input class="form-control" name="load_shipper_weight"
                                        value="{{ $delivered->load_shipper_weight }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Commodity <code>*</code></label>
                                    <input class="form-control" name="load_shipper_commodity" type="text"
                                        value="{{ $delivered->load_shipper_commodity }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Value($)<code>*</code></label>
                                    <input class="form-control" name="load_shipper_value"
                                        value="{{ $delivered->load_shipper_value }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Shipping Notes</label>
                                    <input class="form-control" name="load_shipper_shipping_notes"
                                        value="{{ $delivered->load_shipper_shipping_notes }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>P.O Numbers</label>
                                    <input class="form-control" name="load_shipper_po_numbers"
                                        value="{{ $delivered->load_shipper_po_numbers }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input class="form-control" type="number" name="load_shipper_contact"
                                        value="{{ $delivered->load_shipper_contact }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="modal-title">Consignee <a href="#"><i class="fa fa-plus"></i></a></h4>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Consignee <code>*</code><a data-toggle="modal" data-target="#add-consignee"
                                            style="color:#0c7ce6">Add
                                            New</a></label>
                                    <input class="form-control" name="load_consignee"
                                        value="{{ $delivered->load_consignee }}">
                                    <ul id="consigneeList" class="list-group"></ul>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input class="form-control" name="load_consignee_location"
                                        value="{{ $delivered->load_consignee_location }}">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Date And Time<code>*</code></label>
                                    <input class="form-control" type="datetime-local" name="load_consignee_appointment"
                                        value="{{ $delivered->load_consignee_appointment }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input class="form-control" name="load_consignee_discription"
                                        value="{{ $delivered->load_consignee_discription }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Commodity Type </label>
                                    <input class="form-control select2" name="load_consignee_type"
                                        value="{{ $delivered->load_consignee_type }}">
                                </div>
                            </div>

                            <div class=" col-md-3">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input class="form-control" name="load_consignee_qty"
                                        value="{{ $delivered->load_consignee_qty }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Weight (lbs)</label>
                                    <input class="form-control" name="load_consignee_weight"
                                        value="{{ $delivered->load_consignee_weight }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Commodity <code>*</code></label>
                                    <input class="form-control" name="load_consignee_commodity" type="text"
                                        value="{{ $delivered->load_consignee_commodity }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Value($)<code>*</code></label>
                                    <input class="form-control" name="load_consignee_value"
                                        value="{{ $delivered->load_consignee_value }}">
                                </div>
                            </div>



                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Delivery Notes <code>*</code></label>
                                    <input class="form-control" name="load_consignee_delivery_notes"
                                        value="{{ $delivered->load_consignee_delivery_notes }}">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>P.O Numbers</label>
                                    <input class="form-control" name="load_consignee_po_numbers"
                                        value="{{ $delivered->load_consignee_po_numbers }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Pro Miles</label>
                                    <input class="form-control" name="load_consignee_pro_miles"
                                        value="{{ $delivered->load_consignee_pro_miles }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Empty</label>
                                    <input class="form-control" name="load_consignee_empty"
                                        value="{{ $delivered->load_consignee_empty }}">
                                </div>
                            </div>



                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input class="form-control" type="number" name="load_consigneer_contact"
                                        value="{{ $delivered->load_consigneer_contact }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Consignee Notes</label>
                                    <input class="form-control" type="number" name="load_consigneer_notes"
                                        value="{{ $delivered->load_consigneer_notes }}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Comment / Notes</label>
                                    <input class="form-control" type="text" name="comment"
                                        value="{{ $delivered->comment }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <input type="submit" class="btn btn-info" value="Update Load">
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                    </div>
            </div>
            </form>
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
                                    <input class="form-control" name="consignee_ext">
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
        <form id="mailForm" enctype="multipart/form-data" action="{{ route('send.email') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Custom Email</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="toEmail">To:</label>
                        <input type="email" class="form-control" id="toEmail" name="toEmail"
                            placeholder="Enter recipient email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="attachment">Attachment:</label>
                        <input type="file" class="form-control-file" id="attachments" name="attachments[]" multiple>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter message"
                            required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="sendMailBtn" class="btn btn-primary">Send Mail</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#sendMailBtn').click(function (e) {
                    e.preventDefault();

                    var form = $('#mailForm')[0];
                    var formData = new FormData(form);

                    $.ajax({
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        url: '/send-email',
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (response) {
                            console.log(response);
                            alert(response.message);
                            // Optionally clear form fields or perform other actions
                        },
                        error: function (xhr, status, error) {
                            var errorMessage = xhr.responseJSON.message;
                            alert('Error: ' + errorMessage);
                        }
                    });
                });
            });
        </script>


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

                // Show the modal
                $('#view-file').modal('show');
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
@endsection