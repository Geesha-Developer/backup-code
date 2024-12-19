@extends('layouts.admin.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
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
    .dropdown-menu.show {
    display: block;
    left: -60px !important;
    width: max-content !important;
}
    .card-header {
        background-color: #555555 !important;
        margin-bottom: 15px !important;
        padding: 0.55rem 1.25rem;
    }

    .upload-button input.upload {
        position: absolute;
        right: -9999px;
        visibility: hidden;
        opacity: 0;
    }

    .upload-button p.choose-file {
        padding: 9px 6px;
        font-size: 18px;
        color: #728f22;
    }

    label.upload-button {
        text-align: center;
        border: 1px solid #ccc;
        height: 80px;
        border-radius: 8px;
    }

    h3.card-title.head {
        font-size: 13px;
        text-align: left;
        margin-left: 0px;
        font-weight: 700;
        color: #000;
        margin-top: 16px;
    }

    #shipperForms .nav {
        justify-content: left;
        background: #c7c7c6 !important;
        padding: 4px 0 7px 4px;
        margin: -8px 0 0 0;
    }

    #shipperForms .nav li {
        border: 1px solid #ccc;
        padding: 3px 4px;
        border-radius: 10px;
        background: #fff;
        margin-right: 10px;
        margin-top: 2px;
    }

    .card-body .form-group label {
        font-size: 13px !important;
        text-align: left;

    }

    .card-header h3 {
        font-size: 13px;
        text-align: left;
        margin-left: 0;
        font-weight: 700;
    }

    #consigneeSections .nav {
        justify-content: left;
        background: #c7c7c6 !important;
        padding: 4px 0 7px 4px;
    }

    #consigneeSections .nav li {
        border: 1px solid #ccc;
        padding: 3px 4px;
        border-radius: 10px;
        background: #fff;
        margin-right: 10px;
        margin-top: 2px;
    }

    #consigneeSections .nav li a {
        color: #000 !important;
        background: unset;
        border: unset !important;
        font-size: 12px;
    }

    #shipperForms .nav li a {
        color: #000 !important;
        background: unset;
        border: unset !important;
        font-size: 12px;
    }

    .card-body .form-group {
        margin: 10px 0 4px 0;
    }

    .card-body .form-group label {
        margin-bottom: 0;
        font-weight: 600;
        font-size: 16px;
        color: #4a4a4a;
    }

    .card-body .form-group .form-control {
        height: 28px !important;
        font-size: 11px !important;
    }

    .card-body {
        padding: 0 20px;
        text-align: left !important;
    }

    select#country {
        line-height: unset !important;
    }

    select#state {
        line-height: unset !important;
    }

    select.form-control.select2 {
        line-height: unset !important;
    }

    select.form-control.select2.mr-2 {
        line-height: unset !important;
    }

    button.close {
        position: absolute;
        right: 11px;
        top: -13px !important;
        color: #ffff;
    }
    .table-responsive {
            max-height: 73vh;
            overflow-y: auto; 
        }
        
        thead th {
            position: sticky;
            top: 0;
            z-index: 10; 
            border-bottom: 1px solid #dee2e6; 
        }

        .table th, .table td {
            white-space: nowrap; 
        }
        .modal-header h4 {
    font-size: 17px;
    text-align: left;
    font-weight: 700;
}
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important;">
            <h2><b>All Data</b></h2>
        </div>

        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true" style="font-size: 15px;color: #000;font-weight:500">Customer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="carriers-tab" data-bs-toggle="tab" href="#carriers" role="tab" aria-controls="carriers" aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Carriers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="customers-tab" data-bs-toggle="tab" href="#customers" role="tab" aria-controls="customers" aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Consignee</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dispatchers-tab" data-bs-toggle="tab" href="#dispatchers" role="tab" aria-controls="dispatchers" aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Shipper</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="loads-tab" data-bs-toggle="tab" href="#loads" role="tab" aria-controls="loads" aria-selected="false" style="font-size: 15px;color: #000;font-weight:500">Loads</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" id="dispatchers" role="tabpanel" aria-labelledby="dispatchers-tab">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal3">ADD SHIPPER</button>
                                    
                                <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close"
                                                style="top: 17px !important; color: #101010 !important;"
                                                data-dismiss="modal" aria-label="close">
                                                &times;
                                            </button>
                                            <form method="POST" action="{{ route('shipper_insert') }}" id="myForm">
                                                @csrf
                                                <div class="card-header m-0">
                                                    <h3 class="card-title head">Add Shipper</h3>
                                                </div>
                                                <div class="card-body text-left">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Name <code>*</code></label>
                                                                <input type="text" class="form-control"
                                                                    name="shipper_name" required
                                                                    style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Address<code>*</code></label>
                                                                <input type="text" class="form-control" required
                                                                    name="shipper_address" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Country <code>*</code></label>
                                                                <div>
                                                                    <select style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;width: 100%;height:30px !important;padding: 0px 0 0 10px;" class="form-control select2" required name="customer_country" id="country">
                                                                        <option style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                            selected="selected" class="hiddenOption">Please Select
                                                                        </option>
                                                                        @foreach($countries as $c)
                                                                        <?php $countryValue = $c->id . '|' . $c->name; ?>
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                            value="{{ $countryValue }}">{{$c->name}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>State <code>*</code></label>
                                                                <div>
                                                                    <select
                                                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;width: 100%;height:30px !important;padding: 0px 0 0 10px;"
                                                                        class="form-control select2" required
                                                                        name="customer_state" id="state">
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                            selected="selected"
                                                                            class="hiddenOption">Please Select
                                                                        </option>
                                                                        @foreach($states as $s)
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                            value="{{ $s->id }}|{{ $s->name }}">
                                                                            {{$s->name}}</option>
                                                                        @endforeach
                                                                    </select>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>City <code>*</code></label>
                                                                <input type="text" class="form-control select2"
                                                                    required name="customer_city" id="customer_city"
                                                                    style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Zip <code>*</code></label>
                                                                <input type="number" class="form-control select2"
                                                                    required name="customer_zip" id="customer_zip"
                                                                    style="width: 100%;height:30px !important ;padding: 0px 0 0 10px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Contact Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="shipper_contact_name"
                                                                    style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Contact Email</label>
                                                                <input type="email" class="form-control"
                                                                    name="shipper_contact_email"
                                                                    style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Telephone <code>*</code></label>
                                                                <input type="number" class="form-control"
                                                                    name="shipper_telephone" required
                                                                    style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Ext. </label>
                                                                <input type="text" class="form-control"
                                                                    name="shipper_extn" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Fax</label>
                                                                <input type="text" class="form-control"
                                                                    name="shipper_fax" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Appointments</label>
                                                                <select class="form-control select2"
                                                                    name="shipper_appointments"
                                                                    style="width: 100%;">
                                                                    <option selected="selected">Select</option>
                                                                    <option>Yes</option>
                                                                    <option>No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Status <code>*</code></label>
                                                                <select class="form-control select2"
                                                                    name="shipper_status" required
                                                                    style="width: 100%;">
                                                                    <option selected="selected">Select</option>
                                                                    <option>Active</option>
                                                                    <option>In-Active</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group d-flex align-items-center"
                                                                style=" margin-top: 29px;margin-left: 17px;">
                                                                <label class="one-line-label mr-2"
                                                                    style="white-space: nowrap;">Add as
                                                                    consignee</label>

                                                                <input class="form-check-input" type="checkbox"
                                                                    name="same_as_consignee" id="same_as_consignee"
                                                                    style="    margin-top: 0;" value="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    style="margin-bottom: 0;font-weight: 600;font-size: 16px;color: #4a4a4a;">Shipping
                                                                    Notes </label>
                                                                <textarea class="form-control"
                                                                    name="shipper_shipping_notes"
                                                                    style="width: 100%;height: 61px;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    style="margin-bottom: 0;font-weight: 600;font-size: 16px;color: #4a4a4a;">Internal
                                                                    Notes </label>
                                                                <textarea class="form-control"
                                                                    name="shipper_internal_notes"
                                                                    style="width: 100%;height: 61px;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <input type="submit" class="btn btn-info text-white"
                                                        value="Add">
                                                    <input type="button" class="btn btn-danger text-white"
                                                        data-dismiss="modal" value="Cancel">
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th style="color: #fff !important;">Sr No.</th>
                                                <th style="color: #fff !important;">Shipper Name</th>
                                                <th style="color: #fff !important;">Address</th>
                                                <th style="color: #fff !important;">Phone No</th>
                                                <th style="color: #fff !important;">Added Date</th>
                                                <th style="color: #fff !important;">Agent</th>
                                                <th style="color: #fff !important;">Team Leader</th>
                                                <th style="color: #fff !important;">Manager</th>
                                                <th style="color: #fff !important;">Status</th>
                                                <th style="color: #fff !important;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach($shipper as $fetches)
                                            <tr>
                                                <td class="dynamic-data">{{ $i++ }}</td>
                                                <td class="dynamic-data">{{ $fetches->shipper_name }}</td>
                                                <td class="dynamic-data">{{ $fetches->shipper_address }}</td>
                                                <td class="dynamic-data">{{ $fetches->shipper_telephone }}</td>
                                                <td class="dynamic-data">
                                                    {{ \Carbon\Carbon::parse($fetches->created_at)->format('m-d-Y') }}
                                                </td>
                                                <td class="dynamic-data">{{ $fetches->user_name }}</td>
                                                <td class="dynamic-data">{{ $fetches->manager }}</td>
                                                <td class="dynamic-data">{{ $fetches->team_lead }}</td>
                                                <td class="dynamic-data">{{ $fetches->shipper_status }}</td>
                                                <td class="dynamic-data">
                                                <div class="d-flex justify-content-center">
                                                <!-- <a href="#" style="margin-right: 7px;"><i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i></a> -->
                                                <a href="#"><i class="fa fa-trash" style="font-size: 17px;color: #DC3545;"></i></a>
                                                </div>
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">ADD
                                    CONSIGNEE</button>
                                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" style="top: 17px !important; color: #101010 !important;"
                                                data-dismiss="modal" aria-label="close">
                                                &times;
                                            </button>
                                            <form method="POST" action="{{ route('consignee.data.post') }}" id="myForm">
                                                @csrf
                                                <div class="card-header m-0">
                                                    <h3 class="card-title head">Add Consignee</h3>
                                                </div>
                                                <div class="card-body text-left">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Name <code>*</code></label>
                                                                <input class="form-control" name="consignee_name" required style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Address <code>*</code></label>
                                                                <input class="form-control" name="consignee_address" required style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Country <code>*</code></label>
                                                                <div>
                                                                    <select class="form-control select2" required required name="consignee_country"
                                                                        id="country">
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                            selected="selected" class="hiddenOption">Choose Country
                                                                        </option>
                                                                        @foreach($countries as $c)
                                                                        <option value="{{ $c->id }}" data-name="{{ $c->name }}">
                                                                            {{ $c->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>State <code>*</code></label>
                                                                <div>
                                                                    <select class="form-control select2" required name="consignee_state" id="state">
                                                                        <option selected="selected">Please
                                                                            Select
                                                                        </option>
                                                                        @foreach($states as $s)
                                                                        <option>{{$s->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>City <code>*</code></label>
                                                                <input class="form-control" required name="consignee_city" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Zip <code>*</code></label>
                                                                <input type="number" class="form-control" required name="consignee_zip"
                                                                    style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Major Intersections</label>
                                                                <input class="form-control" name="consignee_major_intersections"
                                                                    style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Status <code>*</code></label>
                                                                <select class="form-control" required name="consignee_status"
                                                                    style="width: 100%;height: 35px;padding: 1px">
                                                                    <option selected="selected">Select Status
                                                                    </option>
                                                                    <option value="Active">Active</option>
                                                                    <option value="In-Active">In-Active</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Contact Number</label>
                                                                <input class="form-control" name="consignee_contact_name" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Contact Email</label>
                                                                <input class="form-control" name="consignee_contact_email" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Telephone <code>*</code></label>
                                                                <input type="number" class="form-control" required name="consignee_telephone"
                                                                    style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Ext. </label>
                                                                <input class="form-control" name="consignee_ext" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Toll Free</label>
                                                                <input class="form-control" name="consignee_toll_free" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Fax</label>
                                                                <input class="form-control" name="consignee_fax" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Consignee Hours</label>
                                                                <input type="time" class="form-control" name="consignee_hours" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Appointments</label>
                                                                <select class="form-control select2" name="consignee_appointments"
                                                                    style="width: 100%;">
                                                                    <option selected="selected">Please Select
                                                                    </option>
                                                                    <option>No</option>
                                                                    <option>Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="one-line-label mr-2" style="white-space: nowrap;">Add as
                                                                    Shipper</label>
                                                                <input class="checkbox" type="checkbox" name="consignee_add_shippper"
                                                                    id="consignee_add_shippper" value="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    style="margin-bottom: 0;font-weight: 600;font-size: 16px;color: #4a4a4a;">Internal
                                                                    Notes </label>
                                                                <textarea class="form-control" name="consignee_internal_notes"
                                                                    style="width: 100%;height: 61px;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    style="margin-bottom: 0;font-weight: 600;font-size: 16px;color: #4a4a4a;">Shipping
                                                                    Notes </label>
                                                                <textarea class="form-control" name="consignee_shipping_notes"
                                                                    style="width: 100%;height: 61px;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Assuming you are in a Blade view file (e.g., create.blade.php) -->
                                                    <input type="text" name="added_by_user" value="" readonly hidden>

                                                </div>
                                                <div class="text-center">
                                                    <input type="submit" class="btn btn-info text-white" value="Add" onclick="saveFormData()">
                                                    <input type="button" class="btn btn-danger text-white" data-dismiss="modal" value="Cancel">
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive dataTable no-footer" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th style="color: #fff !important;">Sr No</th>
                                                <th style="color: #fff !important;">Consignee Name</th>
                                                <th style="color: #fff !important;">Address</th>
                                                <th style="color: #fff !important;">Phone No</th>
                                                <th style="color: #fff !important;">Added Date</th>
                                                <th style="color: #fff !important;">Agent</th>
                                                <th style="color: #fff !important;">Team Leader</th>
                                                <th style="color: #fff !important;">Manager</th>
                                                <th style="color: #fff !important;">Status</th>
                                                <th style="color: #fff !important;">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach($consignee as $consigne)
                                            <tr>
                                                <td class="dynamic-data">{{ $i++ }}</td>
                                                <td class="dynamic-data">{{ $consigne->consignee_name }}</td>
                                                <td class="dynamic-data">{{ $consigne->consignee_address }}</td>
                                                <td class="dynamic-data">{{ $consigne->consignee_telephone }}</td>
                                                <td class="dynamic-data">
                                                    {{ \Carbon\Carbon::parse($fetches->created_at)->format('m-d-Y') }}
                                                </td>
                                                <td class="dynamic-data">{{ $consigne->user->name }}</td>
                                                <td class="dynamic-data">{{ $consigne->user->team_lead }}</td>
                                                <td class="dynamic-data">{{ $consigne->user->manager }}</td>
                                                <td class="dynamic-data">{{ $consigne->consignee_status }}</td>
                                                <td class="dynamic-data">
                                                    <div class="d-flex justify-content-center">
                                                        <!-- <a href="{{ route('admin.consignee.edit', ['id' => $consigne->id]) }}">
                                                                                    <i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i>
                                                                                </a> -->
                                                        <a href="#"><i class="fa fa-trash" style="font-size: 17px;color: #DC3545;"></i></a>
                                                    </div>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="loads" role="tabpanel" aria-labelledby="loads-tab">
                                <div class="row mb-1">
                                    <div class="col-md-6">
                                         <button type="button" class="btn btn-primary m-0" data-toggle="modal" data-target="#add-load">Create Load</button>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="color-pallet d-flex justify-content-end">
                                            <li><div class="triangle-up" style="background: #f9e79f;"></div>Open</li><hr>
                                            <li><div class="triangle-up" style="background: #ffcccb;"></div>Delivered</li><hr>
                                            <li><div class="triangle-up" style="background: #82e0aa;"></div>Invoiced</li>
                                        </ul>
                                    </div>
                                </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered dataTable no-footer" data-page-length="50">    
                                            <div class="modal" id="add-load">
                                                <div class="modal-dialog modal-lg" style="max-width:1300px;">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="card-title head">Add Load</h3>
                                                        <button type="button" class="close"
                                                            style="top: 25px !important;"
                                                            data-dismiss="modal" aria-label="close">
                                                            &times;
                                                        </button>
                                                    </div>
                                                        
                                                        <form method="POST" action="{{ route('load_insert') }}"
                                                            id="myFormLoad" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="card-body text-left pt-0 pb-0">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Load Number
                                                                                <code>*</code></label>
                                                                            <input class="form-control" name="load_number"
                                                                                disabled style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Bill To <code>*</code>&nbsp;<a
                                                                                    href="{{ url('/customer') }}"
                                                                                    id="bill_to_add_request"
                                                                                    style="color:#0c7ce6"><i
                                                                                        class="fa fa-plus"></i> Add
                                                                                    New</a>
                                                                            </label>
                                                                            <input type="text" id="load_bill_to"
                                                                                name="load_bill_to" class="form-control"
                                                                                required
                                                                                placeholder="Search Customer names...">
                                                                            <textarea id="customerList" class="form-control"
                                                                                style="display: none;" readonly></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Dispatcher <code>*</code></label>
                                                                            <input class="form-control"
                                                                                name="load_dispatcher" value="" required
                                                                                readonly style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Status</label>
                                                                            <select class="form-control select2"
                                                                                name="load_status" style="width: 100%;">
                                                                                <option selected="selected" value="Open">
                                                                                    Open
                                                                                </option>
                                                                                <option value="Covered">Covered
                                                                                </option>
                                                                                <option value="Dispatched">
                                                                                    Dispatched</option>
                                                                                <option value="Loading">Loading
                                                                                </option>
                                                                                <option value="On Route">On Route
                                                                                </option>
                                                                                <option value="Un loading">Un
                                                                                    loading</option>
                                                                                <option value="completed">Delivered
                                                                                </option>
                                                                                <option value="completed">completed
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>W/O # </label>
                                                                            <input class="form-control"
                                                                                name="load_workorder" style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Payment Type
                                                                                <code>*</code></label>
                                                                            <select class="form-control select2" required
                                                                                name="load_payment_type"
                                                                                style="width: 100%;">
                                                                                <option selected="selected">Select
                                                                                    Status
                                                                                </option>
                                                                                <option>Prepaid</option>
                                                                                <option>Postpaid</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Load type</label>
                                                                            <div class="select2-purple">
                                                                                <select class="form-control select2"
                                                                                    name="load_type_two"
                                                                                    style="width: 100%;">
                                                                                    <option selected="selected">
                                                                                        Select Status
                                                                                    </option>
                                                                                    <option>OTR</option>
                                                                                    <option>DRAYAGE</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Type <code>*</code></label>
                                                                            <input class="form-control" required
                                                                                name="load_type" style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Shipper Rate
                                                                                <code>*</code></label>
                                                                            <input type="number"
                                                                                class="form-control number value"
                                                                                name="load_shipper_rate"
                                                                                id="load_shipper_rate" required
                                                                                style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-6 col-md-3">
                                                                        <div class="form-group">
                                                                            <label>F.S.C Rate % <input hidden
                                                                                    type="checkbox"
                                                                                    name="calculate_fsc_percentage"
                                                                                    id="calculate_fsc_percentage"></label>
                                                                            <input class="form-control number percent"
                                                                                name="load_fsc_rate" id="load_fsc_rate"
                                                                                style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-6 col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="other_charge" style="width:100%;">Customer Other Charges &nbsp;
                                                                                <i class="fa fa-plus" style="color: #0c7ce6;" data-toggle="modal" data-target="#customer-charge" id="load_shipper_other_charges"></i>
                                                                                <input class="form-control number percent" readonly style="width: 100%;">
                                                                            </label>
                                                                        </div>
                                                                        <div class="modal close_shipper_other_charges_form" id="customer-charge">
                                                                            <div class="modal-dialog" style="max-width: 700px;">
                                                                                <div class="modal-content">

                                                                                    <!-- Modal Header -->
                                                                                    <div class="modal-header">
                                                                                        <h4>Shipper Other Charges</h4>
                                                                                        <button type="button" class="close" data-dismiss="modal" style="font-size: 23px;top: 30px !important;">×</button>
                                                                                    </div>

                                                                                    <!-- Modal Body -->
                                                                                    <div class="modal-body">
                                                                                        <div class="container" id="chargeContainer">
                                                                                            <div class="row chargeRow">
                                                                                                <div class="col-md-6">
                                                                                                    <div class="form-group">
                                                                                                        <label for="shipperchargeType">Charge Type:</label>
                                                                                                        <input type="text" class="form-control" name="shipperchargeType[]" placeholder="Enter charge type">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-5">
                                                                                                    <div class="form-group">
                                                                                                        <label>Amount:</label>
                                                                                                        <input type="number" class="form-control" name="shipperchargeAmount[]" placeholder="Enter amount">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-1 m-auto">
                                                                                                    <a type="button" class="remove-charge" style="margin-top: 34px;">
                                                                                                        <i class="fa fa-trash" style="color:red;" aria-hidden="true"></i>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="text-center mb-3">
                                                                                        <button type="button" class="btn btn-success" style="padding: 6px 27px;font-size: 14px;" id="addChargeBtn">Add Charge</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Final Shipper Rate</label>
                                                                            <input class="form-control result" disabled
                                                                                name="shipper_load_final_rate"
                                                                                id="shipper_load_final_rate"
                                                                                style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>MC No <code>*</code></label>
                                                                            <input class="form-control" required
                                                                                name="load_mc_no" id="carrier_mc_ff_input"
                                                                                style="width: 100%;"
                                                                                placeholder="Enter MC Number">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Carrier <code>*</code></label>
                                                                            <!-- <input type="text" id="searchInput" name="load_carrier" class="form-control" placeholder="Search carrier names..."> -->
                                                                            <input type="text" id="load_carrier"
                                                                                name="load_carrier" class="form-control"
                                                                                style="width: 100%;"
                                                                                placeholder="Search carrier names...">

                                                                            <div id="carrierList"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Carrier Phone <code>*</code></label>
                                                                            <input type="text" class="form-control"
                                                                                style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Advance Payment</label>
                                                                            <input class="form-control"
                                                                                name="load_advance_payment"
                                                                                style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Billing Type</label>
                                                                            <select class="form-control select2"
                                                                                name="load_billing_type"
                                                                                style="width: 100%;">
                                                                                <option selected="selected">Select
                                                                                    Billing
                                                                                </option>
                                                                                <option>Factoring</option>
                                                                                <option>Direct Billing</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Carrier Fee
                                                                                <code>*</code></label>
                                                                            <input class="form-control" type="number"
                                                                                name="load_carrier_fee"
                                                                                id="load_carrier_fee" required
                                                                                style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>FSC Rate %</label>
                                                                            <input type="text" name="load_billing_fsc_rate"
                                                                                id="load_billing_fsc_rate"
                                                                                class="form-control" style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="other_charge">Carrier Other Charges</label>
                                                                            <i class="fa fa-plus" style="color: #0c7ce6;" data-toggle="modal" data-target="#otherChargesModal"></i>
                                                                            <input class="form-control" name="load_other_charge" readonly style="width: 100%;">
                                                                        </div>

                                                                        <!-- Modal -->
                                                                        <div class="modal" id="otherChargesModal">
                                                                            <div class="modal-dialog" style="max-width: 700px;">
                                                                                <div class="modal-content">
                                                                                    <!-- Modal Header -->
                                                                                    <div class="modal-header">
                                                                                        <h4>Carrier Other Charges</h4>
                                                                                        <button type="button" class="close" style="font-size: 23px;top: 30px !important;" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>

                                                                                    <!-- Modal Body -->
                                                                                    <div class="modal-body" id="inputsContainer">
                                                                                        <div class="row chargeRow">
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group">
                                                                                                    <label>Charge Type:</label>
                                                                                                    <input class="form-control" type="text" name="shipper_type_charge[]" placeholder="Enter charges type">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-5">
                                                                                                <div class="form-group">
                                                                                                    <label>Amount:</label>
                                                                                                    <input class="form-control" type="number" name="shipper_other_charge[]" placeholder="Enter amount">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                <div class="form-group">
                                                                                                    <a type="button" class="remove-charge" style="margin-top: 24px;">
                                                                                                        <i class="fa fa-trash" style="color:red;" aria-hidden="true"></i>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Modal Footer -->
                                                                                    <div class="col-md-12 text-center mb-3">
                                                                                        <button type="button" style=" padding: 6px 27px;font-size: 14px;" class="create-input btn btn-success">Add More Charges</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Final Carrier Fee</label>
                                                                            <input class="form-control" readonly
                                                                                name="load_final_carrier_fee"
                                                                                id="load_final_carrier_fee"
                                                                                style="width: 100%;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Currency</label>
                                                                            <select class="form-control select2"
                                                                                name="load_currency" style="width: 100%;">
                                                                                <option selected="selected">Select
                                                                                    Currency
                                                                                </option>
                                                                                <option>$</option>
                                                                                <option>CA$</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Equipment Type
                                                                                <code>*</code></label>
                                                                            <select class="form-control select2" required
                                                                                name="load_equipment_type"
                                                                                style="width: 100%;">
                                                                                <option selected="selected">Select
                                                                                    Equipment
                                                                                </option>
                                                                                <option value="Container Trailer">
                                                                                    Container
                                                                                    Trailer</option>
                                                                                <option value="22' VAN">22' VAN
                                                                                </option>
                                                                                <option value="48' Reefer">48'
                                                                                    Reefer</option>
                                                                                <option value="53' Reefer">53'
                                                                                    Reefer</option>
                                                                                <option value="53' VAN">53' VAN
                                                                                </option>
                                                                                <option value="Air Freight">Air
                                                                                    Freight</option>
                                                                                <option value="Anhydros Ammonia">
                                                                                    Anhydros
                                                                                    Ammonia</option>
                                                                                <option value="Animal Carrier">
                                                                                    Animal Carrier
                                                                                </option>
                                                                                <option value="Any Equipment">Any
                                                                                    Equipment
                                                                                </option>
                                                                                <option value="Searching Services only">
                                                                                    Any
                                                                                    Equipment (Searching Services
                                                                                    only)</option>
                                                                                <option value="Auto Carrier">Auto
                                                                                    Carrier
                                                                                </option>
                                                                                <option value="B-Train/Supertrain">
                                                                                    B-Train/Supertrain</option>
                                                                                <option value="Canada Only">
                                                                                    B-Train/Supertrain(Canada Only)
                                                                                </option>
                                                                                <option value="Beam">Beam</option>
                                                                                <option value="Belly Dump">Belly
                                                                                    Dump</option>
                                                                                <option value="Blanket Wrap Van">
                                                                                    Blanket Wrap
                                                                                    Van</option>
                                                                                <option value="Boat Hauling Trailer">
                                                                                    Boat
                                                                                    Hauling Trailer</option>
                                                                                <option value="Cargo Van (1 Ton)">
                                                                                    Cargo Van (1
                                                                                    Ton)</option>
                                                                                <option value="Cargo Vans (1 Ton capacity)">
                                                                                    Cargo Vans (1 Ton capacity)
                                                                                </option>
                                                                                <option value="Cargo/Small/Sprinter Van">
                                                                                    Cargo/Small/Sprinter Van
                                                                                </option>
                                                                                <option value="Conestoga">Conestoga
                                                                                </option>
                                                                                <option value="Convertible Hopper">
                                                                                    Convertible
                                                                                    Hopper</option>
                                                                                <option value="Conveyor Belt">
                                                                                    Conveyor Belt
                                                                                </option>
                                                                                <option value="Crane Truck">Crane
                                                                                    Truck</option>
                                                                                <option value="Curtain Siders">
                                                                                    Curtain Siders
                                                                                </option>
                                                                                <option value="Curtain Van">Curtain
                                                                                    Van</option>
                                                                                <option value="Double Drop">Double
                                                                                    Drop</option>
                                                                                <option value="Double Drop Extendable">
                                                                                    Double
                                                                                    Drop Extendable</option>
                                                                                <option value="Drive Away">Drive
                                                                                    Away</option>
                                                                                <option value="Dump Trucks">Dump
                                                                                    Trucks</option>
                                                                                <option value="End Dump">End Dump
                                                                                </option>
                                                                                <option value="Flat Intermodal">Flat
                                                                                    Intermodal
                                                                                </option>
                                                                                <option value="Flat with Traps">Flat
                                                                                    with Traps
                                                                                </option>
                                                                                <option value="FlatBed">FlatBed
                                                                                </option>
                                                                                <option value="FlatBed - Air-ride">
                                                                                    FlatBed -
                                                                                    Air-ride</option>
                                                                                <option value="Flatbed Blanket Wrapped">
                                                                                    Flatbed
                                                                                    Blanket Wrapped</option>
                                                                                <option value="Flatbed Intermodal">
                                                                                    Flatbed
                                                                                    Intermodal</option>
                                                                                <option value="Flatbed or Step Deck">
                                                                                    Flatbed or
                                                                                    Step Deck</option>
                                                                                <option value="Flatbed or Van">
                                                                                    Flatbed or Van
                                                                                </option>
                                                                                <option value="Flatbed or Vented Van">
                                                                                    Flatbed or
                                                                                    Vented Van</option>
                                                                                <option
                                                                                    value="Flatbed Over-Dimension Loads">
                                                                                    Flatbed Over-Dimension Loads
                                                                                </option>
                                                                                <option value="Flatbed With Sides">
                                                                                    Flatbed With
                                                                                    Sides</option>
                                                                                <option value="Flatbed, Step Deck or Van">
                                                                                    Flatbed, Step Deck or Van
                                                                                </option>
                                                                                <option value="Flatbed, Van or Reefer">
                                                                                    Flatbed,
                                                                                    Van or Reefer</option>
                                                                                <option
                                                                                    value="Flatbed, Vented Van or Reefer">
                                                                                    Flatbed, Vented Van or Reefer
                                                                                </option>
                                                                                <option value="Haul and Tow Unit">
                                                                                    Haul and Tow
                                                                                    Unit</option>
                                                                                <option value="Hazardous Material Load">
                                                                                    Hazardous Material Load</option>
                                                                                <option value="Hopper Bottom">Hopper
                                                                                    Bottom
                                                                                </option>
                                                                                <option value="Hot Shot">Hot Shot
                                                                                </option>
                                                                                <option value="Labour">Labour
                                                                                </option>
                                                                                <option value="Landoll Flatbed">
                                                                                    Landoll Flatbed
                                                                                </option>
                                                                                <option value="Live Bottom Trailer">
                                                                                    Live
                                                                                    BottomTrailer</option>
                                                                                <option value="Load-Out">Load-Out
                                                                                </option>
                                                                                <option
                                                                                    value="Load-Out are empty trailers you load and haul">
                                                                                    Load-Out are empty trailers you
                                                                                    load and
                                                                                    haul</option>
                                                                                <option value="Lowboy">Lowboy
                                                                                </option>
                                                                                <option value="Lowboy Over-Dimension Loads">
                                                                                    Lowboy Over-Dimension Loads
                                                                                </option>
                                                                                <option
                                                                                    value="Maxi or Double Flat Trailers">
                                                                                    Maxi or Double Flat Trailers
                                                                                </option>
                                                                                <option value="Mobile Home">Mobile
                                                                                    Home</option>
                                                                                <option value="Moving Van">Moving
                                                                                    Van</option>
                                                                                <option value="Multi-Axle Heavy Hauler">
                                                                                    Multi-Axle Heavy Hauler</option>
                                                                                <option value="Ocean Freight">Ocean
                                                                                    Freight
                                                                                </option>
                                                                                <option value="Open Top">Open Top
                                                                                </option>
                                                                                <option value="Open Top Van">Open
                                                                                    Top Van
                                                                                </option>
                                                                                <option value="Pneumatic">Pneumatic
                                                                                </option>
                                                                                <option value="Power Only">Power
                                                                                    Only</option>
                                                                                <option value="Power Only (Tow-Away)">
                                                                                    Power Only
                                                                                    (Tow-Away)</option>
                                                                                <option value="Rail">Rail</option>
                                                                                <option value="Reefer Pallet Exchange">
                                                                                    Reefer
                                                                                    Pallet Exchange</option>
                                                                                <option value="Refrigerated (Reefer)">
                                                                                    Refrigerated (Reefer)</option>
                                                                                <option
                                                                                    value="Refrigerated Carrier with Plant Decking">
                                                                                    Refrigerated Carrier with Plant
                                                                                    Decking
                                                                                </option>
                                                                                <option value="Refrigerated Intermodal">
                                                                                    Refrigerated Intermodal</option>
                                                                                <option value="Removable Goose Neck">
                                                                                    Removable
                                                                                    Goose Neck</option>
                                                                                <option value="Multi-Axle Heavy Haulers">
                                                                                    Removable Goose Neck &amp;
                                                                                    Multi-Axle Heavy
                                                                                    Haulers</option>
                                                                                <option value="GN Extendable">RGN
                                                                                    Extendable
                                                                                </option>
                                                                                <option value="Roll Top Conestoga">
                                                                                    Roll Top
                                                                                    Conestoga</option>
                                                                                <option value="Roller Bed">Roller
                                                                                    Bed</option>
                                                                                <option value="Specialized Trailers">
                                                                                    Specialized
                                                                                    Trailers</option>
                                                                                <option value="Step Deck">Step Deck
                                                                                </option>
                                                                                <option value="Step Deck Conestoga">
                                                                                    Step Deck
                                                                                    Conestoga</option>
                                                                                <option value="Step Deck Extendable">
                                                                                    Step Deck
                                                                                    Extendable</option>
                                                                                <option value="Step Deck or Flat">
                                                                                    Step Deck or
                                                                                    Flat</option>
                                                                                <option
                                                                                    value="Step Deck or Removable Gooseneck">
                                                                                    Step Deck or Removable
                                                                                    Gooseneck</option>
                                                                                <option
                                                                                    value="Step Deck Over-Dimension Loads">
                                                                                    Step Deck Over-Dimension
                                                                                    Loads</option>
                                                                                <option
                                                                                    value="Step Deck with Loading Ramps">
                                                                                    Step Deck with Loading
                                                                                    Ramps
                                                                                </option>
                                                                                <option value="Straight Van">
                                                                                    Straight Van
                                                                                </option>
                                                                                <option
                                                                                    value="Stretch Trailer or Ext. Flat">
                                                                                    Stretch Trailer or Ext.
                                                                                    Flat
                                                                                </option>
                                                                                <option
                                                                                    value="Stretch Trailer or Extendable Flatbed">
                                                                                    Stretch Trailer or
                                                                                    Extendable Flatbed</option>
                                                                                <option value="Supplies">Supplies
                                                                                </option>
                                                                                <option value="Tandem Van">Tandem
                                                                                    Van</option>
                                                                                <option value="Tanker">Tanker
                                                                                </option>
                                                                                <option
                                                                                    value="Tanker (Food grade, liquid, bulk, etc.)">
                                                                                    Tanker (Food
                                                                                    grade,
                                                                                    liquid, bulk, etc.)</option>
                                                                                <option value="Team Driver Needed">
                                                                                    Team Driver
                                                                                    Needed</option>
                                                                                <option value="Tridem">Tridem
                                                                                </option>
                                                                                <option value="Two 24 or 28 Foot Flatbeds">
                                                                                    Two
                                                                                    24 or 28 Foot Flatbeds
                                                                                </option>
                                                                                <option
                                                                                    value="Unspecified Specialized Trailers">
                                                                                    Unspecified Specialized
                                                                                    Trailers</option>
                                                                                <option value="Van">Van</option>
                                                                                <option value="Van - Air-Ride">Van -
                                                                                    Air-Ride
                                                                                </option>
                                                                                <option value="Van Intermodal">Van
                                                                                    Intermodal
                                                                                </option>
                                                                                <option value="Van or Flatbed">Van
                                                                                    or Flatbed
                                                                                </option>
                                                                                <option value="Van or Reefer">Van or
                                                                                    Reefer
                                                                                </option>
                                                                                <option value="Van Pallet Exchange">
                                                                                    Van Pallet
                                                                                    Exchange</option>
                                                                                <option value="Van with Liftgate">
                                                                                    Van with
                                                                                    Liftgate</option>
                                                                                <option value="Van, Reefer or Double Drop">
                                                                                    Van,
                                                                                    Reefer or Double Drop
                                                                                </option>
                                                                                <option value="Vented Insulated Van">
                                                                                    Vented
                                                                                    Insulated Van</option>
                                                                                <option
                                                                                    value="Vented Insulated Van or Refrigerated">
                                                                                    Vented Insulated
                                                                                    Van or
                                                                                    Refrigerated</option>
                                                                                <option value="Vented Van">Vented
                                                                                    Van</option>
                                                                                <option value="Vented Van or Refrigerated">
                                                                                    Vented Van or Refrigerated
                                                                                </option>
                                                                                <option value="Walking Floor">
                                                                                    Walking Floor
                                                                                </option>
                                                                                <option value="BOX Truck">BOX Truck
                                                                                </option>
                                                                                <option value="Reefer Container">
                                                                                    Reefer
                                                                                    Container</option>
                                                                                <option value="Tandem">Tandem
                                                                                </option>
                                                                                <option value="B Train">B Train
                                                                                </option>
                                                                                <option value="Flatbed with Tarps">
                                                                                    Flatbed with
                                                                                    Tarps</option>
                                                                                <option value="Flatbed with straps">
                                                                                    Flatbed with
                                                                                    straps</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Delivery Order</label>
                                                                            <input class="form-control" type="file" readonly
                                                                                name="load_delivery_do_file"
                                                                                id="load_delivery_do_file"
                                                                                style="width: 100%; font-size:9px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-header mb-0">
                                                                <h3 class="card-title">Shipper <i id="addBtn"
                                                                        class="fa fa-plus"></i></h3>
                                                            </div>
                                                            <div class="card-body" id="shipperForms">
                                                                <ul class="nav nav-tabs" id="navTabs">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active"
                                                                            style="padding: 1px 11px;" id="formTab1"
                                                                            data-bs-toggle="tab" href="#shipperForm1"
                                                                            role="tab" aria-controls="shipperForm1"
                                                                            aria-selected="true">Shipper 1</a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content" id="tabContent">
                                                                    <div class="tab-pane fade show active" id="shipperForm1"
                                                                        role="tabpanel" aria-labelledby="formTab1">
                                                                        <div class="row shipper-form">
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Shipper <code>*</code>
                                                                                        <a href="{{ route('shipper') }}"
                                                                                            target="blank"
                                                                                            style="background: none; border: none;">
                                                                                            <i class="fa fa-plus"></i>Add
                                                                                            New
                                                                                        </a>
                                                                                    </label>
                                                                                    <input class="form-control"
                                                                                        name="load_shipper"
                                                                                        id="load_shipper" required
                                                                                        autocomplete="off"
                                                                                        style="width: 100%;">
                                                                                    <div id="shipperList"
                                                                                        class="form-control"
                                                                                        style="height: auto !important;width: 100% !important"
                                                                                        style="display: none;" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Shipper Location</label>
                                                                                    <input class="form-control"
                                                                                        name="load_shipper_location"
                                                                                        id="load_shipper_location"
                                                                                        style="width: 100%;" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Appointment</label>
                                                                                    <input class="form-control"
                                                                                        type="datetime-local"
                                                                                        name="load_shipper_appointment"
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Description</label>
                                                                                    <input class="form-control"
                                                                                        name="load_shipper_description"
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Commodity Type</label>
                                                                                    <input class="form-control select2"
                                                                                        name="load_shipper_commodity_type"
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Commodity Name
                                                                                        <code>*</code></label>
                                                                                    <input class="form-control"
                                                                                        name="load_shipper_commodity"
                                                                                        type="text" required
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Qty</label>
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        name="load_shipper_qty"
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Weight (lbs)</label>
                                                                                    <input class="form-control"
                                                                                        type="number"
                                                                                        name="load_shipper_weight"
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Value($)<code>*</code></label>
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        name="load_shipper_value" required
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Shipping Notes</label>
                                                                                    <input class="form-control"
                                                                                        name="load_shipper_shipping_notes"
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>PO Numbers</label>
                                                                                    <input class="form-control"
                                                                                        name="load_shipper_po_numbers"
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label>Contact Number</label>
                                                                                    <input class="form-control"
                                                                                        type="number"
                                                                                        name="load_shipper_contact"
                                                                                        style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-header mb-0">
                                                                <h3 class="card-title">Consignee <i id="addBtnconsignee"
                                                                        class="fa fa-plus"></i>
                                                                </h3>
                                                            </div>
                                                            <div class="card-body1" id="consigneeSections"
                                                                style="padding: 0 20px;">
                                                                <ul class="nav nav-tabs" id="navTabs1">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active"
                                                                            style="padding: 1px 11px;" id="formTab1"
                                                                            data-bs-toggle="tab" href="#consigneeSections1"
                                                                            role="tab" aria-controls="consigneeSections1"
                                                                            aria-selected="true">Consignee 1</a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content" id="tabContent1">
                                                                    <div class="tab-pane fade show active"
                                                                        id="consigneeSections1" role="tabpanel"
                                                                        aria-labelledby="formTab1">
                                                                        <div class="consignee-section card-body p-0">
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Consignee <code>*</code>
                                                                                            <a href="{{ route('consignee') }}"
                                                                                                target="blank"
                                                                                                style="background: none; border: none;">
                                                                                                <i class="fa fa-plus"></i>Add New
                                                                                            </a>
                                                                                        </label>
                                                                                        <input class="form-control" name="load_consignee" id="load_consignee" required style="width: 100%;">
                                                                                        <div id="consigneeList" class="form-control" style="height: auto !important;width: 100% !important; font-size: 11px;" style="display: none;" readonly>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Consignee Location</label>
                                                                                        <input class="form-control"
                                                                                            name="load_consignee_location"
                                                                                            id="load_consignee_location"
                                                                                            style="width: 100%;" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Appointment<code>*</code></label>
                                                                                        <input class="form-control"
                                                                                            type="datetime-local"
                                                                                            name="load_consignee_appointment"
                                                                                            required style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Description</label>
                                                                                        <input class="form-control"
                                                                                            name="load_consignee_description"
                                                                                            style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Commodity Type </label>
                                                                                        <input class="form-control select2"
                                                                                            name="load_consignee_type"
                                                                                            style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Commodity Name
                                                                                            <code>*</code></label>
                                                                                        <input class="form-control"
                                                                                            name="load_consignee_commodity"
                                                                                            type="text" required
                                                                                            style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Qty</label>
                                                                                        <input class="form-control"
                                                                                            name="load_consignee_qty"
                                                                                            style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Weight (lbs)</label>
                                                                                        <input class="form-control"
                                                                                            type="number"
                                                                                            name="load_consignee_weight"
                                                                                            style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Value($)<code>*</code></label>
                                                                                        <input class="form-control"
                                                                                            name="load_consignee_value"
                                                                                            required style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Delivery Notes</label>
                                                                                        <input class="form-control"
                                                                                            name="load_consignee_delivery_notes"
                                                                                            style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>PO Numbers</label>
                                                                                        <input class="form-control"
                                                                                            name="load_consignee_po_numbers"
                                                                                            style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Contact Number</label>
                                                                                        <input class="form-control"
                                                                                            type="number"
                                                                                            name="load_consignee_contact"
                                                                                            style="width: 100%;">
                                                                                    </div>
                                                                                </div>
                                                                                <!-- <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Consignee
                                                                                            Notes</label>
                                                                                        <textarea class="form-control"
                                                                                            name="load_consignee_notes"
                                                                                            style="width: 100%; height: 85px !important;"></textarea>
                                                                                    </div>
                                                                                </div> -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="text-center mb-4 mt-3">
                                                                <input type="submit" class="btn btn-info text-white" value="Save">
                                                                <button type="button" class="btn btn-warning" id="clearFormButton" style="font-size:14px !important; padding: 6px 27px;background: #FF9948 !important; color:#fff;">Clear Form</button>
                                                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                                                            </div>
                                                        </form>


                                                    </div>
                                                </div>
                                            </div>
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
                                                    <th style="color: #fff !important;">Carrier MC</th>
                                                    <th style="color: #fff !important;">Carrier</th>                                                
                                                    <th style="color: #fff !important;">Pickup Location</th>
                                                    <th style="color: #fff !important;">Unloading Location</th>
                                                    <th style="color: #fff !important;">Load Status</th>
                                                    <th style="color: #fff !important;">Margin</th>
                                                    <th style="color: #fff !important;">Margin %</th>
                                                    <th style="color: #fff !important;">Aging</th>
                                                    <th style="color: #fff !important;">Delivered Aging</th>
                                                    <th style="color: #fff !important;">Carrier PDF</th>
                                                    <th style="color: #fff !important;">Shipper PDF</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = 1;
                                                @endphp
                                                @foreach($loads as $load)
                                                <tr class="load-row {{ 
                                                        $load->load_status == 'Open' ? 'row-open' : 
                                                        ($load->load_status == 'Delivered' && $load->invoice_status == 'Paid' ? 'row-delivered-paid' : 
                                                        ($load->load_status == 'Delivered' && $load->invoice_status == 'Paid Record' ? 'row-delivered-paid-record' : 
                                                        ($load->load_status == 'Delivered' ? 'row-delivered' : ''))) 
                                                    }}" data-created-at="{{ $load->created_at->format('m-d-Y') }}">
                                                    <td class="dynamic-data">{{ $i++ }}</td>
                                                    <td class="dynamic-data" id="load_number">
                                                         <a style="color: #0d6efd !important;font-weight: 700;cursor:pointer" onclick="openUploadWindow('{{ route('admin.load.edit', $load->id) }}')">{{ $load->load_number }}</a>
                                                    </td>
                                                    <td class="dynamic-data">{{ $load->user->name }}</td>
                                                    <td class="dynamic-data">
                                                    @if(!empty($load->invoice_number))
                                                    {{ $load->invoice_number }}
                                                    @else
                                                    -
                                                    @endif
                                                    </td>
                                                    <td class="dynamic-data">
                                                    @if(!empty($load->invoice_date) && $load->invoice_date !== '0000-00-00')
                                                        {{ \Carbon\Carbon::parse($load->invoice_date)->format('m-d-Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                    </td>
                                                    <td class="dynamic-data">{{ $load->load_workorder }}</td>
                                                    <td class="dynamic-data">{{ $load->load_bill_to }}</td>
                                                    <td class="dynamic-data">{{ $load->user->office }}</td>
                                                    <td class="dynamic-data">{{ $load->user->team_lead }}</td>
                                                    <td class="dynamic-data">{{ $load->user->manager }}</td>
                                                    <td class="dynamic-data">{{ $load->created_at->format('m-d-Y') }}</td>
                                                        @php
                                                        $shipper_appointment = json_decode($load->load_shipper_appointment,true);
                                                        @endphp
                                                    <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                                        @php
                                                            $consignee_appointment = json_decode($load->load_consignee_appointment,true);
                                                        @endphp
                                                        <td class="dynamic-data">
                                                            {{ isset($consignee_appointment[0]['appointment']) && strtotime($consignee_appointment[0]['appointment']) 
                                                                ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                                                : '' }}
                                                        </td>
                                                        <td class="dynamic-data">
                                                            {{ \Carbon\Carbon::parse($load->load_actual_delivery_date)->format('m-d-Y') }}
                                                        </td>
                                                    <td class="dynamic-data">{{ $load->load_mc_no }}</td>
                                                    <td class="dynamic-data">
                                                        {{ $load->load_carrier }}</td>
                                                    @php
                                                        $shipper_location = json_decode($load->load_shipper_location,true);
                                                    @endphp
                                                    <td class="dynamic-data">
                                                        {{ $shipper_location[0]['location'] ?? '' }}
                                                    </td>
                                                    @php
                                                        $consignee_loaction = json_decode($load->load_consignee_location,
                                                    true);
                                                    @endphp

                                                    <td class="dynamic-data">
                                                        {{ $consignee_loaction[0]['location'] ?? '' }}
                                                    </td>
                                                    <td class="dynamic-data">
                                                        @if($load->load_status == 'Open')
                                                            Open
                                                        @elseif($load->load_status == 'Delivered' && $load->invoice_status == 'Paid')
                                                           Invoiced
                                                        @elseif($load->load_status == 'Delivered' && $load->invoice_status != 'Paid' && $load->invoice_status != 'Paid Record')
                                                            Delivered
                                                        @elseif($load->load_status == 'Delivered' && $load->invoice_status == 'Paid Record')
                                                            Paid
                                                        @endif
                                                    </td>

                                                    @php
                                                        $shipperRate = floatval($load->shipper_load_final_rate);
                                                        $carrierFee = floatval($load->load_final_carrier_fee);
                                                        $getMargin = $shipperRate - $carrierFee;
                                                    @endphp
                                                    <td class="dynamic-data">${{ number_format($getMargin, 2) }}</td>
                                                    @php
                                                            $shipperRate = floatval($load->shipper_load_final_rate);
                                                            $carrierFee = floatval($load->load_final_carrier_fee);
                                                            $getMargin = $shipperRate - $carrierFee;

                                                            // Calculate margin percentage
                                                            if ($shipperRate > 0) {
                                                                $marginPercent = ($getMargin / $shipperRate) * 100;
                                                            } else {
                                                                $marginPercent = 0; // Handle division by zero case
                                                            }
                                                        @endphp

                                                    <!-- Display the margin percentage and set color based on whether the percentage is negative or positive -->
                                                    <td class="dynamic-data" style="color: {{ $marginPercent >= 0 ? 'green' : 'red' }};">
                                                        {{ number_format($marginPercent, 2) }}%
                                                    </td>
                                                
                                                    <td class="dynamic-data">
                                                        @php
                                                            $differenceInDays = null;
                                                            if (isset($load->invoice_date)) {
                                                                $invoiceDate = \Carbon\Carbon::parse($load->invoice_date);
                                                                $currentDate = \Carbon\Carbon::now();
                                                                if ($load->invoice_status == 'Paid') {
                                                                    $differenceInDays = $invoiceDate->diffInDays($currentDate);
                                                                } elseif ($load->invoice_status == 'Paid Record') {
                                                                    // If the invoice status is 'Paid Record', aging is complete
                                                                    $differenceInDays = 'Paid';
                                                                }
                                                            }
                                                            $isInvoiceStatusEmpty = empty($load->invoice_status);
                                                        @endphp

                                                        @if($isInvoiceStatusEmpty)
                                                            <span>-</span>
                                                        @elseif($differenceInDays !== null)
                                                            @if($load->invoice_status == 'Paid')
                                                            <span style="color:red">{{ $differenceInDays }} days</span>
                                                            @elseif($load->invoice_status == 'Paid Record')
                                                                <span style="color:green">{{ $differenceInDays }}</span>
                                                            @endif
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    </td>
                                                    <td class="dynamic-data">
                                                        @php
                                                            $differenceInDays = null;

                                                            // Check if the load has a delivery date and the status is Delivered
                                                            if ($load->load_status == 'Delivered' && !empty($load->load_actual_delivery_date)) {
                                                                $deliveryDate = \Carbon\Carbon::parse($load->load_actual_delivery_date);
                                                                $currentDate = \Carbon\Carbon::now();

                                                                // If the invoice status is 'Paid', aging is complete
                                                                if ($load->invoice_status == 'Paid') {
                                                                    $differenceInDays = 'Received to accounting';
                                                                } 
                                                                // Otherwise, calculate aging days from delivery date
                                                                else {
                                                                    $differenceInDays = $deliveryDate->diffInDays($currentDate);
                                                                }
                                                            }
                                                        @endphp

                                                        @if(empty($load->load_actual_delivery_date))
                                                            <span>-</span>
                                                        @elseif($differenceInDays === 'Received to accounting')
                                                            <span style="color:green">{{ $differenceInDays }}</span>
                                                        @elseif($differenceInDays !== null)
                                                            <span style="color:red">{{ $differenceInDays }} days</span>
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    </td>






                                                    <td class="dynamic-data text-center" style=" vertical-align: middle !important;">
                                                        <a href="{{ route('admin.rc.download.pdf', ['id' => $load->id]) }}" target="_blank">
                                                            <i class="fas fa-file-pdf text-danger" aria-hidden="true" style="font-size: 24px;"></i>
                                                        </a>
                                                    </td>
                                                    <td class="dynamic-data text-center" style=" vertical-align: middle !important;">
                                                        <a href="{{ route('admin.shipper.rc.download.pdf', ['id' => $load->id]) }}" target="_blank">
                                                            <i class="fas fa-file-pdf text-danger" aria-hidden="true" style="font-size: 24px;"></i>
                                                        </a>
                                                    </td>
                                                    <!-- <td class="dynamic-data"><button class="btn btn-sm btn-danger">Delete</button></td> -->
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">  
                                <div class="body p-0">
                                    <div class="col-md-12 p-0 date-time mb-2">
                                        <div class="date d-flex mt-0">
                                            <label for="start">Start Date:</label>
                                            <div class="browse-button position-relative">
                                                <img src="{{ asset('assets/images/schedule.png') }}" width="25" class="calendar-icon" />
                                                <input id="startDate" class="start_filter filter-dropdown calendar-input" />
                                            </div>
                                        </div>
                                        <div class="date d-flex mt-0">
                                            <label for="end">End Date:</label>
                                            <div class="browse-button position-relative">
                                                <img src="{{ asset('assets/images/schedule.png') }}" width="25" class="calendar-icon" />
                                                <input id="endDate" class="end_filter filter-dropdown calendar-input" />
                                            </div>
                                        </div>

                                        <select name="manager" id="manager" class="manager_filter filter-dropdown"
                                            style="margin-left:7px; margin-top: 7px; height: 20px;color: #3e3e40;">
                                            <option value="" selected>Sort By Manager</option>
                                            @foreach($manager as $managers)
                                            <option value="{{ $managers->manager }}">{{ $managers->manager }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <select name="team_lead" id="team_lead"
                                            class="team_lead_filter filter-dropdown"
                                            style="height: 20px;color: #3e3e40;margin-left:7px; margin-top: 7px;">
                                            <option value="" selected>Sort By TL</option>
                                            @foreach($teamlead as $teamLead)
                                            <option value="{{ $teamLead->tl }}">{{ $teamLead->tl }}</option>
                                            @endforeach
                                        </select>
                                        <select name="office" id="office" class="office_filter filter-dropdown"
                                            style="height: 20px;color: #3e3e40;margin-left:7px; margin-top: 7px;">
                                            <option value="" selected>Sort By Office</option>
                                            @foreach($office as $offices)
                                            @if($offices->status == 'Active')
                                            <option value="{{ $offices->office_name }}">{{ $offices->office_name }}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" style="margin-left: 7px;font-size: 13px;"
                                            data-target="#exampleModal"> ADD CUSTOMER </button>
                                    </div>
                                        
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="close"
                                                        style="top: 17px !important; color: #101010 !important;">
                                                        &times;
                                                    </button>
                                                    <form method="POST" action="{{ route('customer.insert.by.admin') }}" id="myForm" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="card-header m-0">
                                                            <h3 class="card-title head">CUSTOMER DETAILS</h3>
                                                        </div>

                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Customer Name <code>*</code></label>
                                                                        <input class="form-control select2"
                                                                            type="text" required
                                                                            name="customer_name"
                                                                            style="width: 100%;height:30px !important ;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <input type="text" name="user_id" hidden>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="mr-2">MC# /FF#
                                                                            </label>
                                                                        <div class="d-flex" style="width: 100%;">
                                                                            <select
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 38%;height:30px !important"
                                                                                class="form-control select2 mr-2"
                                                                                name="customer_mc_ff">
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
                                                                            <input class="form-control select2"
                                                                                name="customer_mc_ff_input"
                                                                                style="width: 65%;height:30px !important;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Address <code>*</code></label>
                                                                        <input type="text"
                                                                            class="form-control select2" required
                                                                            name="customer_address"
                                                                            id="customer_address"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px;  ">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Country <code>*</code></label>
                                                                        <div>
                                                                            <select class="form-control select2"
                                                                                required name="customer_country"
                                                                                id="country">
                                                                                <option
                                                                                    style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                                    selected="selected"
                                                                                    class="hiddenOption">
                                                                                    Choose Country
                                                                                </option>
                                                                                @foreach($countries as $c)
                                                                                <?php $countryValue = $c->id ?>
                                                                                <option
                                                                                    style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                                    value="{{ $c->id }}">
                                                                                    {{$c->name}}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>State <code>*</code></label>
                                                                        <div>
                                                                            <select class="form-control select2"
                                                                                required name="customer_state"
                                                                                id="state">
                                                                                <option
                                                                                    style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                                    selected="selected"
                                                                                    class="hiddenOption">
                                                                                    Please Select
                                                                                </option>
                                                                                @foreach($states as $s)
                                                                                <option
                                                                                    style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                                    value="{{ $s->id }}|{{ $s->name }}">
                                                                                    {{$s->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>City <code>*</code></label>
                                                                        <input type="text"
                                                                            class="form-control select2" required
                                                                            name="customer_city" id="customer_city"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Zip <code>*</code></label>
                                                                        <input type="number"
                                                                            class="form-control select2" required
                                                                            name="customer_zip" id="customer_zip"
                                                                            style="width: 100%;height:30px !important ;padding: 0px 0 0 10px;">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group d-flex mt-3">
                                                                        <input class="form-check mr-2"
                                                                            type="checkbox" name="same_as_physical"
                                                                            id="same_as_physical">
                                                                        <label class="one-line-label"
                                                                            style="white-space: nowrap;">Same as
                                                                            Physical Address</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Billing Address
                                                                            <code>*</code></label>
                                                                        <input type="text"
                                                                            class="form-control select2" required
                                                                            type="text"
                                                                            name="customer_billing_address"
                                                                            id="customer_billing_address"
                                                                            style="width: 100%;height:30px !important ;padding: 0px 0 0 10px;">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Billing City <code>*</code></label>
                                                                        <input type="text"
                                                                            class="form-control select2" required
                                                                            name="customer_billing_city"
                                                                            id="customer_billing_city"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Billing State <code>*</code></label>
                                                                        <input type="text"
                                                                            class="form-control select2" required
                                                                            name="customer_billing_state"
                                                                            id="customer_billing_state"
                                                                            style="width: 100%;height:30px !important ;padding: 0px 0 0 10px;">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Billing Zip <code>*</code></label>
                                                                        <input type="number"
                                                                            class="form-control select2" required
                                                                            name="customer_billing_zip"
                                                                            id="customer_billing_zip"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Billing Country
                                                                            <code>*</code></label>
                                                                        <input type="text"
                                                                            class="form-control select2" required
                                                                            type="text"
                                                                            name="customer_billing_country"
                                                                            id="customer_billing_country"
                                                                            style="width: 100%;height:30px !important ;padding: 0px 0 0 10px;">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>POC Name</label>
                                                                        <input type="text"
                                                                            class="form-control select2"
                                                                            name="customer_primary_contact"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>AP Contact </label>
                                                                        <input type="number" maxlimit="12"
                                                                            class="form-control select2"
                                                                            name="customer_telephone"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Ap Extn. </label>
                                                                        <input type="text"
                                                                            class="form-control select2"
                                                                            name="customer_extn"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Email <code>*</code></label>
                                                                        <input type="email"
                                                                            class="form-control select2" required
                                                                            name="customer_email"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-3">
                                                                    <div class="form-group">
                                                                        <label>Website URL </label>
                                                                        <input class="form-control select2"
                                                                            name="adv_customer_webiste_url"
                                                                            id="adv_customer_webiste_url"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Fax</label>
                                                                        <input type="text"
                                                                            class="form-control select2"
                                                                            name="customer_fax"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Acc Pay Email</label>
                                                                        <input type="email"
                                                                            class="form-control select2"
                                                                            name="customer_secondary_email"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Telephone <code>*</code></label>
                                                                        <input type="number"
                                                                            class="form-control select2" required
                                                                            name="customer_billing_telephone"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Extn.</label>
                                                                        <input type="text"
                                                                            class="form-control select2"
                                                                            name="customer_billing_extn"
                                                                            style="width: 100%;height:30px !important ;padding: 0px 0 0 10px;">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group align-items-center">
                                                                        <label class="mr-2">Status
                                                                            <code>*</code></label>
                                                                        <div>
                                                                            <select
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px !important;padding: 0px 0 0 10px; "
                                                                                class="form-control select2"
                                                                                required name="customer_status">
                                                                                <option
                                                                                    style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                                    selected="selected"
                                                                                    class="hiddenOption">
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
                                                        </div>
                                                        <div class="card-header m-0">
                                                            <h3 class="card-title head">ADVANCED</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Currency Setting
                                                                        </label>
                                                                        <div class="d-flex"
                                                                            style="width: 100%; height: 30px;">
                                                                            <select
                                                                                class="form-control select2 mr-2"
                                                                                name="adv_customer_currency_Setting">
                                                                                <option selected="selected"
                                                                                    class="hiddenOption">Please
                                                                                    Select
                                                                                </option>
                                                                                <option>
                                                                                    American Dollars
                                                                                </option>
                                                                                <option>
                                                                                    Canadian Dollars
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Payment Terms </label>
                                                                        <div class="d-flex" style="width: 100%;  ">
                                                                            <div class="d-flex"
                                                                                style="width: 100%;  ">
                                                                                <select class="form-control select2"
                                                                                    name="adv_customer_payment_terms"
                                                                                    onchange="showInput()">
                                                                                    <option value="Net 30">Net30
                                                                                    </option>
                                                                                    <option
                                                                                        value="Quick Pay 6% 1 Day">
                                                                                        Quick Pay
                                                                                        6% 1 Day</option>
                                                                                    <option
                                                                                        value="Quick Pay 4% 5 Days">
                                                                                        Quick
                                                                                        Pay 4% 5 Days</option>
                                                                                    <option value="Prepay">Prepay
                                                                                    </option>
                                                                                    <option value="Custom"
                                                                                        id="custome">
                                                                                        Custom
                                                                                    </option>
                                                                                </select>
                                                                                <input class="form-control select2"
                                                                                    name="adv_customer_payment_terms_custome"
                                                                                    style="width: 100%; height: 30px; display: none;"
                                                                                    id="custome_input">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Credit Limits</label>
                                                                        <input class="form-control select2" type="number" name="approved_limit" style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Credit Limits</label>
                                                                        <input class="form-control select2"
                                                                            type="number"
                                                                            name="adv_customer_credit_limit"
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Sales Rep. <code>*</code></label>
                                                                        <input type="text"
                                                                            class="form-control select2"
                                                                            name="adv_customer_sales_rep" value=""
                                                                            readonly
                                                                            style="width: 100%;height:30px !important;padding: 0px 0 0 10px; ">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="control-label mb-1 el_min100">Duplicate</label>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" id="AddAsShipper"
                                                                                name="AddAsShipper">
                                                                            <label class="form-check-label"
                                                                                for="AddAsShipper"
                                                                                style="font-size:12px;">Add as
                                                                                Shipper</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" id="AddAsConsignee"
                                                                                name="AddAsConsignee">
                                                                            <label class="form-check-label"
                                                                                for="AddAsConsignee"
                                                                                style="font-size:12px;">Add as
                                                                                Consignee</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label style="line-height: 1.2em;">Upload
                                                                            files</label><br>
                                                                        <label for="upload" class="upload-button"
                                                                            style="height: 59px; width:100%;">
                                                                            <input type="file" class="upload"
                                                                                id="upload" multiple="">
                                                                            <p class="choose-file">Choose the file
                                                                            </p>
                                                                        </label>
                                                                        <p>Please upload the file you want to share
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label style="line-height: 1.2em;">Internal
                                                                            Notes
                                                                        </label>
                                                                        <textarea class="form-control select2"
                                                                            type="text"
                                                                            name="adv_customer_internal_notes"
                                                                            id="adv_customer_internal_notes"
                                                                            style="width: 100%; height:60px !important;"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="text-center">
                                                                <input type="submit" class="btn btn-info text-white"
                                                                    value="Add">
                                                                <input type="button"
                                                                    class="btn btn-danger text-white"
                                                                    data-dismiss="modal" value="Cancel">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-responsive dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th style="color: #fff !important;">Sr No.</th>
                                                    <th style="color: #fff !important;">Agent</th>
                                                    <th style="color: #fff !important;">Company</th>
                                                    <th style="color: #fff !important;">Address</th>
                                                    <th style="color: #fff !important;">Phone No</th>
                                                    <th style="color: #fff !important">Date Added</th>
                                                    <th style="color: #fff !important;">Team Leader</th>
                                                    <th style="color: #fff !important;">Manager</th>
                                                    <th style="color: #fff !important;">Office</th>
                                                    <th style="color: #fff !important;">Requested Credit</th>
                                                    <th style="color: #fff !important;">Credit Used</th>
                                                    <th style="color: #fff !important;">Remaining Limit</th>
                                                    <th style="color: #fff !important;">Approved Status</th>
                                                    <th style="color: #fff !important;">Last Load</th>
                                                    <th style="color: #fff !important;">Action</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $sortedCustomers = $customers->sortBy(function ($customer) {
                                                    return $customer->status === 'Not Approved' ? 0 : 1; // Prioritize Not Approved
                                                });
                                            @endphp
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach($sortedCustomers as $customer)
                                                @if(!empty($customer->customer_name))
                                                <tr class="load-row 
                                                        {{ $customer->status == 'Approved' ? 'row-approved' : '' }} 
                                                        {{ $customer->status == 'Not Approved' ? 'row-not-approved' : '' }} ">
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $i++ }}</td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->user->name }}</td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                                        <a style="color:#0d6efd !important; font-weight: 700;" href="{{ route('edit.customer', ['id' => $customer->id]) }}" style="text-decoration:unset">
                                                            {{ $customer->customer_name }}</a>
                                                    </td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                                        {{ $customer->customer_address }} {{ $customer->customer_country }} {{ $customer->customer_state }} {{ $customer->customer_city }} {{ $customer->customer_zip }}
                                                    </td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->customer_telephone }}</td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->created_at->format('m-d-Y') }}</td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;" id="filterTeamLead">{{ $customer->user->team_lead }}</td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;" id="filterManager">{{ $customer->user->manager }}</td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;" id="filterOffice">{{ $customer->user->office }}</td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                                        ${{ $customer->adv_customer_credit_limit }}
                                                    </td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                                        ${{ number_format(floatval($customer->adv_customer_credit_limit), 2) }} - ${{ number_format(floatval($customer->adv_customer_credit_limit) - floatval($customer->remaining_credit), 2) }}
                                                    </td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                                        ${{ number_format(floatval($customer->remaining_credit), 2) }}
                                                    </td>
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->status }}</td>
                                                    @php

                                                        // Calculate aging days
                                                        $agingDays = $customer->invoice_date 
                                                            ? Carbon::parse($customer->invoice_date)->diffInDays(Carbon::now()) 
                                                            : null;
                                                    @endphp
                                                    <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $agingDays !== null ? $agingDays . ' days' : 'N/A' }}
                                                    </td>
                                                    <td class="dynamic-data">
                                                        <div class="d-flex justify-content-center">
                                                            @php
                                                                $st = $customer->status;
                                                            @endphp
                                                            <a href="{{ route('edit.customer', ['id' => $customer->id]) }}">
                                                                <i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="delete-customer" data-id="{{ $customer->id }}">
                                                                <i class="fa fa-trash" style="font-size: 17px;color: red;"></i>
                                                            </a>
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
                            <div class="tab-pane fade" id="carriers" role="tabpanel" aria-labelledby="carriers-tab">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">ADD CARRIER</button>

                                <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" style="top: 17px !important; color: #101010 !important;"
                                                data-dismiss="modal" aria-label="close">
                                                &times;
                                            </button>
                                            <form method="POST" action="#" id="myForm">
                                                @csrf
                                                <div class="card-header m-0">
                                                    <h3 class="card-title head">Add Carrier</h3>
                                                </div>
                                                <div class="card-body text-left">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Carrier Name <code>*</code></label>
                                                                <input class="form-control select2" required name="carrier_name"
                                                                    style="width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="mr-2">M.C. #/F.F.#
                                                                    <code>*</code></label>
                                                                <div class="d-flex" style="width: 100%;">
                                                                    <select class="form-control select2 mr-2" required name="carrier_mc_ff"
                                                                        style="width: 35% !important;height:35px ">
                                                                        <option selected="selected">MC</option>
                                                                        <option selected="FF">FF</option>
                                                                        <option selected="NA">NA</option>

                                                                    </select>
                                                                    <input class="form-control select2" required name="carrier_mc_ff_input"
                                                                        style="width: 65%; ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>D.O.T</label>
                                                                <input class="form-control" name="carrier_dot" style="width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Address<code>*</code></label>
                                                                <input class="form-control" name="carrier_address_two" required
                                                                    style="width: 100%;  ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Country<code>*</code></label>
                                                                <select
                                                                    style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;width: 100%;height:30px !important;padding: 0px 0 0 10px;"
                                                                    class="form-control select2" name="carrier_country" id="country">
                                                                    <option
                                                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;"
                                                                        selected="selected">Please Select
                                                                    </option>
                                                                    @foreach($countries as $c)
                                                                    <?php $d= $c->id ;?>
                                                                    <option
                                                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;"
                                                                        value="{{$d}}">{{$c->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>State<code>*</code></label>
                                                                <div>
                                                                    <select
                                                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;width: 100%;height:30px !important;padding: 0px 0 0 10px;"
                                                                        class="form-control select2" name="carrier_state" id="state">
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;"
                                                                            selected="selected">Please Select
                                                                        </option>
                                                                        @foreach($states as $s)
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;">
                                                                            {{$s->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>City<code>*</code></label>
                                                                <input class="form-control" name="carrier_city" required style="width: 100%;  ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Zip<code>*</code></label>
                                                                <input class="form-control" name="carrier_zip" required style="width: 100%;  ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Contact Name</label>
                                                                <input class="form-control" name="carrier_contact_name" style="width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input class="form-control" name="carrier_email" style="width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Telephone<code>*</code></label>
                                                                <input class="form-control" name="carrier_telephone" required style="width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Extn. </label>
                                                                <input class="form-control" name="carrier_extn" style="width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Fax</label>
                                                                <input class="form-control" name="carrier_fax" style="width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Status <code>*</code></label>
                                                                <div class="select2-purple">
                                                                    <select class="form-control select2" name="carrier_status" style="width: 100%; "
                                                                        required>
                                                                        <option selected="selected">Select
                                                                        </option>
                                                                        <option style="font-family: 'Poppins', sans-serif;">
                                                                            Active</option>
                                                                        <option style="font-family: 'Poppins', sans-serif;">
                                                                            In-Active</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Payment Terms </label>
                                                                <div class="select2-purple">
                                                                    <select class="form-control select2" name="carrier_payment_terms"
                                                                        style="width: 100%;  ">
                                                                        <option selected="selected">Select
                                                                            Payment
                                                                        </option>
                                                                        <option style="font-family: 'Poppins', sans-serif;">
                                                                            Prepaid</option>
                                                                        <option style="font-family: 'Poppins', sans-serif;">
                                                                            Postpaid</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Factoring Company <code>*</code></label>
                                                                <input class="form-control" required name="carrier_factoring_company"
                                                                    style="width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label
                                                                    style="margin-bottom: 0; font-weight: 600;font-size: 16px;color: #4a4a4a;">Notes</label>
                                                                <textarea class="form-control" name="carrier_notes"
                                                                    style="width: 100%; height: 70px"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label style="line-height: 1.2em;">Upload
                                                                    files</label><br>
                                                                <label for="upload" class="upload-button" style="height: 66px; width:100%;">
                                                                    <input type="file" class="upload" id="carrier_file_upload" multiple="">
                                                                    <p class="choose-file">Choose the file</p>
                                                                </label>
                                                                <p>Please upload the file you want to share</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-4">
                                                        <input type="submit" class="btn btn-info text-white" value="Add">
                                                        <input type="button" class="btn btn-danger text-white" data-dismiss="modal" value="Cancel">
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-responsive dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th style="color: #fff !important;">
                                                Sr No.</th>
                                            <th style="color: #fff !important;">
                                                Carrier Name</th>
                                            <th style="color: #fff !important;">MC#</th>
                                            <th style="color: #fff !important;">DOT#</th>
                                            <th style="color: #fff !important;">
                                                Address</th>
                                            <th style="color: #fff !important;">Phone No</th>

                                            <th style="color: #fff !important;">Added Date</th>
                                            <th style="color: #fff !important;">Agent</th>
                                            <th style="color: #fff !important;">Team Leader</th>
                                            <th style="color: #fff !important;">Manager</th>
                                            <th style="color: #fff !important;">Status</th>
                                            <th style="color: #fff !important;"> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach($external as $fetches)
                                        <tr id="carrier-row-{{ $fetches->id }}">
                                            <td class="dynamic-data">{{ $i++ }}</td>
                                            <td class="dynamic-data">{{ $fetches->carrier_name }}</td>
                                            <td class="dynamic-data">{{ $fetches->carrier_mc_ff_input }}</td>
                                            <td class="dynamic-data">{{ $fetches->carrier_dot}}</td>
                                            <td class="dynamic-data">{{ $fetches->carrier_address }}</td>
                                            <td class="dynamic-data">{{ $fetches->carrier_telephone }}</td>
                                            <td class="dynamic-data">
                                                {{ \Carbon\Carbon::parse($fetches->created_at)->format('m-d-Y') }}
                                            </td>
                                            <td class="dynamic-data">{{ $fetches->user->name }}</td>
                                            <td class="dynamic-data">{{ $fetches->user->team_lead}}</td>
                                            <td class="dynamic-data">{{ $fetches->user->manager }}</td>
                                            <td class="dynamic-data">{{ $fetches->carrier_status }}</td>
                                            <td class="dynamic-data">
                                                <div class="d-flex justify-content-center">
                                                    <!-- <a href="#" style="margin-right: 7px;"><i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i></a> -->
                                                    <a href="javascript:void(0);" class="delete-carrier" data-id="{{ $fetches->id }}">
                                                        <i class="fa fa-trash" style="font-size: 17px; color: red;"></i>
                                                    </a>

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
</section>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




<script>
    $(function () {
        function fetchCustomerNames(query) {
            if (query.trim().length >= 3) { // Check if the query length is at least three characters
                $.ajax({
                    url: "{{ route('fetch.customer.details') }}",
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
    $(function () {
        function fetchShipperNames(query) {
            if (query.trim() !== '') {
                $.ajax({
                    url: "{{ route('fetch.shipper.details') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    dataType: "json",
                    success: function (response) {
                        var html = '';
                        response.forEach(function (shipper) {
                            html += '<div class="item dropdown-item" data-name="' + shipper
                                .shipper_name + '" data-address="' + shipper
                                .shipper_address + '" data-city="' + shipper.shipper_city +
                                '" data-state="' + shipper.shipper_state +
                                '" data-country="' + shipper.shipper_country +
                                '" data-zip="' + shipper.shipper_zip + '">' + shipper
                                .shipper_name + '</div>';
                        });
                        $('#shipperList').html(html).show();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('#shipperList').html('').hide();
            }
        }

        $('input[name="load_shipper"]').on('keyup', function () {
            var query = $(this).val();
            fetchShipperNames(query);

            // Clear the location field if shipper name is empty
            if (query.trim() === '') {
                $('input[name="load_shipper_location"]').val('');
            }
        });

        // Listen for click event on shipper list items
        $(document).on('click', '#shipperList .item', function () {
            var selectedShipperName = $(this).data('name');
            var selectedShipperAddress = $(this).data('address');
            var selectedShipperCity = $(this).data('city');
            var selectedShipperState = $(this).data('state');
            var selectedShipperCountry = $(this).data('country');
            var selectedShipperZip = $(this).data('zip');

            var fullAddress = selectedShipperAddress + ', ' + selectedShipperCity + ', ' +
                selectedShipperState + ', ' + selectedShipperCountry + ', ' + selectedShipperZip;

            $('input[name="load_shipper"]').val(selectedShipperName);
            $('input[name="load_shipper_location"]').val(fullAddress);
            $('#shipperList').html('').hide(); // Clear the list
        });

        // Hide the dropdown when clicking outside
        $(document).on('click', function (event) {
            if (!$(event.target).closest('#shipperList, input[name="load_shipper"]').length) {
                $('#shipperList').html('').hide();
            }
        });
    });
</script>

<script>
    $(function () {
        function fetchConsigneeNames(query) {
            if (query.trim() !== '') {
                $.ajax({
                    url: "{{ route('fetch.consignee.details') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    dataType: "json",
                    success: function (response) {
                        var html = '';
                        response.forEach(function (consignee) {
                            html += '<div class="item dropdown-item" data-name="' +
                                consignee.consignee_name + '" data-address="' + consignee
                                .consignee_address + '" data-city="' + consignee
                                .consignee_city + '" data-state="' + consignee
                                .consignee_state + '" data-country="' + consignee
                                .consignee_country + '" data-zip="' + consignee
                                .consignee_zip + '">' + consignee.consignee_name + '</div>';
                        });
                        $('#consigneeList').html(html).show();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('#consigneeList').html('').hide();
            }
        }

        $('input[name="load_consignee"]').on('keyup', function () {
            var query = $(this).val();
            fetchConsigneeNames(query);

            // Clear the location field if consignee name is empty
            if (query.trim() === '') {
                $('input[name="load_consignee_location"]').val('');
            }
        });

        // Listen for click event on consignee list items
        $(document).on('click', '#consigneeList .item', function () {
            var selectedConsigneeName = $(this).data('name');
            var selectedConsigneeAddress = $(this).data('address');
            var selectedConsigneeCity = $(this).data('city');
            var selectedConsigneeState = $(this).data('state');
            var selectedConsigneeCountry = $(this).data('country');
            var selectedConsigneeZip = $(this).data('zip');

            var fullAddress = selectedConsigneeAddress + ', ' + selectedConsigneeCity + ', ' +
                selectedConsigneeState + ', ' + selectedConsigneeCountry + ', ' + selectedConsigneeZip;

            $('input[name="load_consignee"]').val(selectedConsigneeName);
            $('input[name="load_consignee_location"]').val(fullAddress);
            $('#consigneeList').html('').hide(); // Clear the list
        });

        // Hide the dropdown when clicking outside
        $(document).on('click', function (event) {
            if (!$(event.target).closest('#consigneeList, input[name="load_consignee"]').length) {
                $('#consigneeList').html('').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        let nextShipperNumber = 2; // Start with the next shipper number to be 2

        $('#addBtn').click(function () {
            let currentShipperNumber = nextShipperNumber++;

            let dynamicRowHTML =
                `<li class="nav-item d-flex" data-shipper-number="${currentShipperNumber}"><a class="nav-link p-0" id="formTab${currentShipperNumber}" data-bs-toggle="tab" href="#shipperForm${currentShipperNumber}" role="tab" aria-controls=shipperForm${currentShipperNumber}" aria-selected="true">Shipper ${currentShipperNumber}</a><i class="fa fa-trash remove" style="margin-top: 1px;margin-left: 12px;"></i></li>`;

            $('#navTabs').append(dynamicRowHTML);
            let formHTML =
                `<div class="tab-pane fade" id="shipperForm${currentShipperNumber}" role="tabpanel" aria-labelledby="formTab${currentShipperNumber}"><div class="row shipper-form">
                <div class="col-md-3">
                <div class="form-group">
                <label>Shipper<code>*</code><button type="button" data-toggle="modal" data-target="#add-shipper" style="background:0 0;border:none"><i class="fa fa-plus"></i>Add New</button></label>
                <input class="form-control load_shipper" name="load_shipper${currentShipperNumber}" id="load_shipper${currentShipperNumber}" required autocomplete="off" style="width:100%">
                <div class="form-control" style="height: auto !important; width: 100% !important;font-size: 11px;" readonly="" id="shipperList${currentShipperNumber}"></div>
                </div>
                </div>
                <div class="col-md-3">
                <div class="form-group">
                <label>Location</label>
                <input class="form-control load_shipper_location" name="load_shipper_location${currentShipperNumber}" id="load_shipper_location${currentShipperNumber}" style="width:100%">
                </div>
                </div>
                <div class="col-md-3">
                <div class="form-group"><label>Appointment</label><input class="form-control" type="datetime-local" name="load_shipper_appointment${currentShipperNumber}" style="width:100%"></div></div><div class="col-md-3"><div class="form-group"><label>Description</label><input class="form-control" name="load_shipper_description${currentShipperNumber}" style="width:100%"></div></div><div class="col-md-3"><div class="form-group"><label>Commodity Type</label><input class="form-control select2" name="load_shipper_commodity_type${currentShipperNumber}" style="width:100%"></div></div><div class="col-md-3"><div class="form-group"><label>Commodity Name<code>*</code></label><input class="form-control" name="load_shipper_commodity${currentShipperNumber}" type="text" required style="width:100%"></div></div><div class="col-md-3"><div class="form-group"><label>Qty</label><input type="number" class="form-control" name="load_shipper_qty${currentShipperNumber}" style="width:100%"></div></div><div class="col-md-3"><div class="form-group"><label>Weight (lbs)</label><input class="form-control" type="number" name="load_shipper_weight${currentShipperNumber}" style="width:100%"></div></div><div class="col-md-3"><div class="form-group"><label>Value($)<code>*</code></label><input type="number" class="form-control" name="load_shipper_value${currentShipperNumber}" required style="width:100%"></div></div><div class="col-md-3"><div class="form-group"><label>Shipping Notes</label><input class="form-control" name="load_shipper_shipping_notes${currentShipperNumber}" style="width:100%"></div></div><div class="col-md-3"><div class="form-group"><label>PO Numbers</label><input class="form-control" name="load_shipper_po_numbers${currentShipperNumber}" style="width:100%"></div></div><div class="col-md-3"><div class="form-group"><label>Contact Number</label><input class="form-control" type="number" name="load_shipper_contact${currentShipperNumber}" style="width:100%"></div></div></div></div>`;

            $('#tabContent').append(formHTML);

            // Attach event handlers to the new shipper form inputs
            attachAutoCompleteHandlers(currentShipperNumber);
        });

        $('#navTabs').on('click', '.remove', function () {
            let tabId = $(this).parent('.nav-item').find('a').attr('href');
            $(this).parent('.nav-item').remove();
            $(tabId).remove();

            reorderShippers();
        });

        function reorderShippers() {
            let shipperCount = 1;
            $('#navTabs .nav-item').each(function () {
                let newShipperNumber = shipperCount++;
                let $navItem = $(this);
                let $navLink = $navItem.find('.nav-link');
                let oldShipperNumber = $navLink.attr('id').match(/\d+/)[0];

                // Update nav item
                $navLink.attr('id', `formTab${newShipperNumber}`);
                $navLink.attr('href', `#shipperForm${newShipperNumber}`);
                $navLink.attr('aria-controls', `shipperForm${newShipperNumber}`);
                $navLink.text(`Shipper ${newShipperNumber}`);

                // Update tab content
                let $tabContent = $(`#shipperForm${oldShipperNumber}`);
                $tabContent.attr('id', `shipperForm${newShipperNumber}`);
                $tabContent.attr('aria-labelledby', `formTab${newShipperNumber}`);

                // Update form fields' names and ids inside the tab content
                $tabContent.find('input, select').each(function () {
                    let $input = $(this);
                    let name = $input.attr('name');
                    let id = $input.attr('id');

                    if (name) {
                        $input.attr('name', name.replace(/\d+/, newShipperNumber));
                    }
                    if (id) {
                        $input.attr('id', id.replace(/\d+/, newShipperNumber));
                    }
                });
            });

            // Reset the next shipper number to the new count
            nextShipperNumber = shipperCount;
        }

        function attachAutoCompleteHandlers(shipperNumber) {
            $(`input[name="load_shipper${shipperNumber}"]`).on('keyup', function () {
                var query = $(this).val();
                fetchShipperNames(query, shipperNumber);

                // Clear the location field if shipper name is empty
                if (query.trim() === '') {
                    $(`input[name="load_shipper_location${shipperNumber}"]`).val('');
                }
            });

            // Listen for click event on shipper list items
            $(document).on('click', `#shipperList${shipperNumber} .item`, function () {
                var selectedShipperName = $(this).data('name');
                var selectedShipperAddress = $(this).data('address');
                var selectedShipperCity = $(this).data('city');
                var selectedShipperState = $(this).data('state');
                var selectedShipperCountry = $(this).data('country');
                var selectedShipperZip = $(this).data('zip');

                var fullAddress = selectedShipperAddress + ', ' + selectedShipperCity + ', ' +
                    selectedShipperState + ', ' + selectedShipperCountry + ', ' + selectedShipperZip;

                $(`input[name="load_shipper${shipperNumber}"]`).val(selectedShipperName);
                $(`input[name="load_shipper_location${shipperNumber}"]`).val(fullAddress);
                $(`#shipperList${shipperNumber}`).html('').hide(); // Clear the list
            });

            // Hide the dropdown when clicking outside
            $(document).on('click', function (event) {
                if (!$(event.target).closest(
                        `#shipperList${shipperNumber}, input[name="load_shipper${shipperNumber}"]`)
                    .length) {
                    $(`#shipperList${shipperNumber}`).html('').hide();
                }
            });
        }

        function fetchShipperNames(query, shipperNumber) {
            if (query.trim() !== '') {
                $.ajax({
                    url: "{{ route('fetch.shipper.details') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    dataType: "json",
                    success: function (response) {
                        var html = '';
                        response.forEach(function (shipper) {
                            html += '<div class="item dropdown-item" data-name="' + shipper
                                .shipper_name + '" data-address="' + shipper
                                .shipper_address + '" data-city="' + shipper.shipper_city +
                                '" data-state="' + shipper.shipper_state +
                                '" data-country="' + shipper.shipper_country +
                                '" data-zip="' + shipper.shipper_zip + '">' + shipper
                                .shipper_name + '</div>';
                        });
                        $(`#shipperList${shipperNumber}`).html(html).show();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $(`#shipperList${shipperNumber}`).html('').hide();
            }
        }
    });
</script>


<script>
    $(document).ready(function () {
        let nextConsigneeNumber = 2; // Start with the next consignee number to be 2

        $('#addBtnconsignee').click(function () {
            let currentConsigneeNumber = nextConsigneeNumber++;

            let dynamicRowHTML = `
                <li class="nav-item d-flex" data-consignee-number="${currentConsigneeNumber}">
                    <a class="nav-link p-0" id="formTab${currentConsigneeNumber}" data-bs-toggle="tab" href="#consigneeSections${currentConsigneeNumber}" role="tab" aria-controls="consigneeSections${currentConsigneeNumber}" aria-selected="true">Consignee ${currentConsigneeNumber}</a>
                    ${currentConsigneeNumber > 1 ? '<i class="fa fa-trash remove" style="margin-top: 1px;margin-left: 12px;"></i>' : ''}
                </li>
            `;
            $('#navTabs1').append(dynamicRowHTML);

            let formHTML = `
                <div class="tab-pane fade" id="consigneeSections${currentConsigneeNumber}" role="tabpanel" aria-labelledby="formTab${currentConsigneeNumber}">
                    <div id="consignee-section">
                        <div class="row card-body p-0">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Consignee <code>*</code>
                                        <button type="button" data-toggle="modal" data-target="#add-consigne" style="background: none; border: none;">
                                            <i class="fa fa-plus"></i>Add New
                                        </button>
                                    </label>
                                    <input class="form-control" name="load_consignee${currentConsigneeNumber}" required style="width: 100%;">
                                    <div class="form-control" style="height: auto !important; width: 100% !important; font-size: 11px;" readonly="" id="consigneeList${currentConsigneeNumber}"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input class="form-control" name="load_consignee_location${currentConsigneeNumber}" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Appointment<code>*</code></label>
                                    <input class="form-control" type="datetime-local" name="load_consignee_appointment${currentConsigneeNumber}" required style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input class="form-control" name="load_consignee_description${currentConsigneeNumber}" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Commodity Type</label>
                                    <input class="form-control select2" name="load_consignee_type${currentConsigneeNumber}" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Commodity Name <code>*</code></label>
                                    <input class="form-control" name="load_consignee_commodity${currentConsigneeNumber}" type="text" required style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input class="form-control" name="load_consignee_qty${currentConsigneeNumber}" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Weight (lbs)</label>
                                    <input class="form-control" type="number" name="load_consignee_weight${currentConsigneeNumber}" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Value($)<code>*</code></label>
                                    <input class="form-control" name="load_consignee_value${currentConsigneeNumber}" required style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Delivery Notes</label>
                                    <input class="form-control" name="load_consignee_delivery_notes${currentConsigneeNumber}" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>PO Numbers</label>
                                    <input class="form-control" name="load_consignee_po_numbers${currentConsigneeNumber}" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input class="form-control" type="number" name="load_consignee_contact${currentConsigneeNumber}" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Consignee Notes</label>
                                    <textarea class="form-control" name="load_consignee_notes${currentConsigneeNumber}" style="width: 100%; height: 85px !important;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('#tabContent1').append(formHTML);

            // Attach autocomplete functionality for the newly added consignee section
            attachAutoCompleteHandlers(currentConsigneeNumber);
        });

        $('#navTabs1').on('click', '.remove', function () {
            $(this).parent('.nav-item').remove();
            let tabId = $(this).parent('.nav-item').find('a').attr('href');
            $(tabId).remove();

            reorderConsignees();
        });

        function reorderConsignees() {
            let consigneeCount = 1;
            $('#navTabs1 .nav-item').each(function () {
                let newConsigneeNumber = consigneeCount++;
                let $navItem = $(this);
                let $navLink = $navItem.find('.nav-link');
                let oldConsigneeNumber = $navLink.attr('id').match(/\d+/)[0];

                // Update nav item
                $navLink.attr('id', `formTab${newConsigneeNumber}`);
                $navLink.attr('href', `#consigneeSections${newConsigneeNumber}`);
                $navLink.attr('aria-controls', `consigneeSections${newConsigneeNumber}`);
                $navLink.text(`Consignee ${newConsigneeNumber}`);

                // Update tab content
                let $tabContent = $(`#consigneeSections${oldConsigneeNumber}`);
                $tabContent.attr('id', `consigneeSections${newConsigneeNumber}`);
                $tabContent.attr('aria-labelledby', `formTab${newConsigneeNumber}`);

                // Update form fields' names and ids inside the tab content
                $tabContent.find('input, select, textarea').each(function () {
                    let $input = $(this);
                    let name = $input.attr('name');
                    let id = $input.attr('id');

                    if (name) {
                        $input.attr('name', name.replace(/\d+/, newConsigneeNumber));
                    }
                    if (id) {
                        $input.attr('id', id.replace(/\d+/, newConsigneeNumber));
                    }
                });
            });

            // Reset the next consignee number to the new count
            nextConsigneeNumber = consigneeCount;
        }

        // Attach autocomplete functionality for the initial consignee section
        attachAutoCompleteHandlers(1);

        function attachAutoCompleteHandlers(consigneeNumber) {
            $(`input[name="load_consignee${consigneeNumber}"]`).on('keyup', function () {
                var query = $(this).val().trim();
                fetchConsigneeNames(query, consigneeNumber);

                // Clear the location field if consignee name is empty
                if (query === '') {
                    $(`input[name="load_consignee_location${consigneeNumber}"]`).val('');
                }
            });

            // Listen for click event on consignee list items
            $(document).on('click', `#consigneeList${consigneeNumber} .item`, function () {
                var selectedConsigneeName = $(this).data('name');
                var selectedConsigneeAddress = $(this).data('address');
                var selectedConsigneeCity = $(this).data('city');
                var selectedConsigneeState = $(this).data('state');
                var selectedConsigneeCountry = $(this).data('country');
                var selectedConsigneeZip = $(this).data('zip');

                var fullAddress = selectedConsigneeAddress + ', ' + selectedConsigneeCity + ', ' +
                    selectedConsigneeState + ', ' + selectedConsigneeCountry + ', ' +
                    selectedConsigneeZip;

                $(`input[name="load_consignee${consigneeNumber}"]`).val(selectedConsigneeName);
                $(`input[name="load_consignee_location${consigneeNumber}"]`).val(fullAddress);
                $(`#consigneeList${consigneeNumber}`).html('').hide(); // Clear the list
            });

            // Hide the dropdown when clicking outside
            $(document).on('click', function (event) {
                if (!$(event.target).closest(
                        `#consigneeList${consigneeNumber}, input[name="load_consignee${consigneeNumber}"]`
                    ).length) {
                    $(`#consigneeList${consigneeNumber}`).html('').hide();
                }
            });
        }

        function fetchConsigneeNames(query, consigneeNumber) {
            if (query !== '') {
                $.ajax({
                    url: "{{ route('fetch.consignee.details') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    dataType: "json",
                    success: function (response) {
                        var html = '';
                        response.forEach(function (consignee) {
                            html +=
                                `<div class="item dropdown-item" data-name="${consignee.consignee_name}" data-address="${consignee.consignee_address}" data-city="${consignee.consignee_city}" data-state="${consignee.consignee_state}" data-country="${consignee.consignee_country}" data-zip="${consignee.consignee_zip}">${consignee.consignee_name}</div>`;
                        });
                        $(`#consigneeList${consigneeNumber}`).html(html).show();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $(`#consigneeList${consigneeNumber}`).html('').hide();
            }
        }
    });
</script>


<script>
    $(document).on('click', '.delete-customer', function() {
        var customerId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this customer?')) {
            $.ajax({
                url: '{{ route('customer.delete', '') }}/' + customerId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.success);
                        // Optionally, remove the deleted customer from the DOM
                        location.reload();
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function(xhr) {
                    alert('Something went wrong! Please try again.');
                }
            });
        }
    });
</script>



<script>
    $(document).on('click', '.delete-carrier', function() {
        var carrierId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this carrier?')) {
            $.ajax({
                url: '{{ route('carrier.delete', '') }}/' + carrierId,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.success);
                        // Remove the carrier row without reloading
                        $('#carrier-row-' + carrierId).remove();
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Log the response text for debugging
                    alert('Something went wrong! Please try again.');
                }
            });
        }
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
    var table = $('.dataTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true
    });

    // Date range filter
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = new Date($('#start').val());
            var max = new Date($('#end').val());
            var date = new Date(data[8]); // Index 8 corresponds to the 'Load Creation Date' column

            if (
                (isNaN(min.getTime()) && isNaN(max.getTime())) ||
                (isNaN(min.getTime()) && date <= max) ||
                (min <= date && isNaN(max.getTime())) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }
    );

    // Manager filter
    $('#manager').on('change', function() {
        table.column(7).search(this.value).draw(); // Index 7 corresponds to the 'Manager' column
    });

    // Team Lead filter
    $('#team_lead').on('change', function() {
        table.column(6).search(this.value).draw(); // Index 6 corresponds to the 'Team Leader' column
    });

    // Office filter
    $('#office').on('change', function() {
        table.column(5).search(this.value).draw(); // Index 5 corresponds to the 'Office' column
    });

    // Date range filter event
    $('#start, #end').on('change', function() {
        table.draw();
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
    document.addEventListener('DOMContentLoaded', function () {
        const chargeContainer = document.getElementById('chargeContainer');
        const addChargeBtn = document.getElementById('addChargeBtn');

        // Add Charge
        addChargeBtn.addEventListener('click', function () {
            // Create a new row for charges
            const chargeRow = document.createElement('div');
            chargeRow.classList.add('row', 'chargeRow');
            chargeRow.innerHTML = `
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="shipperchargeType">Charge Type:</label>
                        <input type="text" class="form-control" name="shipperchargeType[]" placeholder="Enter charge type">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Amount:</label>
                        <input type="number" class="form-control" name="shipperchargeAmount[]" placeholder="Enter amount">
                    </div>
                </div>
                <div class="col-md-1 m-auto">
                    <a type="button" class="remove-charge" style="margin-top: 34px;">
                        <i class="fa fa-trash" style="color:red;" aria-hidden="true"></i>
                    </a>
                </div>
            `;

            // Append the new row to the container
            chargeContainer.appendChild(chargeRow);
        });

        // Remove Charge
        chargeContainer.addEventListener('click', function (event) {
            if (event.target.closest('.remove-charge')) {
                const rowToRemove = event.target.closest('.chargeRow');
                rowToRemove.remove();
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputsContainer = document.getElementById('inputsContainer');
        const addChargeButton = document.querySelector('.create-input');

        // Add new charge row
        addChargeButton.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent form submission or unwanted behavior

            // Create a new charge row
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'chargeRow');
            newRow.innerHTML = `
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Charge Type:</label>
                        <input class="form-control" type="text" name="shipper_type_charge[]" placeholder="Enter charges type">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Amount:</label>
                        <input class="form-control" type="number" name="shipper_other_charge[]" placeholder="Enter amount">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <a type="button" class="remove-charge" style="margin-top: 24px;">
                            <i class="fa fa-trash" style="color:red;" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            `;

            // Append the new row to the container
            inputsContainer.appendChild(newRow);
        });

        // Remove charge row
        inputsContainer.addEventListener('click', function (event) {
            if (event.target.closest('.remove-charge')) {
                const chargeRow = event.target.closest('.chargeRow');
                if (chargeRow) {
                    chargeRow.remove();
                }
            }
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