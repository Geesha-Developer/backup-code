@extends('layouts.broker.app')
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check"></i>
    <h4 class="alert-heading"><b>Well done!</b></h4>
    <p>Your Shipper has been edit Successfully!</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <button type="button" class="btn btn-success" onclick="$('.alert').alert('close');">OK</button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fa fa-warning"></i>
    <h4 class="alert-heading"><b>Error!</b></h4>
    <p>{{ session('error') }}</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <button type="button" class="btn btn-danger" onclick="$('.alert').alert('close');">OK</button>
</div>
@endif

<style>
    button#hideFormButton {
        float: right;
    }
</style>
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>{{ isset($shipper) ? 'Edit Shipper' : 'Add Shipper' }}</h2>
        </div>

        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 p-0">
                    <div class="card">
                        <div class="body">
                            <form action="{{ route('shipper.update', ['id' => $shipper->id]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shipper_name">Name <code>*</code></label>
                                                <input type="text" id="shipper_name" class="form-control"
                                                    name="shipper_name"
                                                    value="{{ old('shipper_name', isset($shipper) ? $shipper->shipper_name : '') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shipper_address">Address<code>*</code></label>
                                                <input type="text" id="shipper_address" class="form-control"
                                                    name="shipper_address" required
                                                    value="{{ old('shipper_address', isset($shipper) ? $shipper->shipper_address : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Country<code>*</code></label>
                                                <select class="form-control select2" name="carrier_country"
                                                    id="country">

                                                    <option
                                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;"
                                                        selected="selected">Please Select</option>
                                                    @foreach($countries as $c)
                                                    <option
                                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;"
                                                        value="{{$c->id}} {{ $c->name }}">{{$c->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>State<code>*</code></label>
                                                <select
                                                    style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="customer_city">City<code>*</code></label>
                                                <input type="text" id="customer_city" class="form-control" required
                                                    name="customer_city"
                                                    value="{{ old('customer_city', isset($shipper) ? $shipper->shipper_city : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="customer_zip">Zip<code>*</code></label>
                                                <input type="text" id="customer_zip" class="form-control"
                                                    name="customer_zip" required
                                                    value="{{ old('customer_zip', isset($shipper) ? $shipper->shipper_zip : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shipper_contact_name">POC Name</label>
                                                <input type="text" id="shipper_contact_name" class="form-control"
                                                    name="shipper_contact_name"
                                                    value="{{ old('shipper_contact_name', isset($shipper) ? $shipper->shipper_contact_name : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shipper_contact_email">Contact Email</label>
                                                <input type="email" id="shipper_contact_email" class="form-control"
                                                    name="shipper_contact_email"
                                                    value="{{ old('shipper_contact_email', isset($shipper) ? $shipper->shipper_contact_email : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shipper_telephone">Telephone </label>
                                                <input type="text" id="shipper_telephone" class="form-control"
                                                    name="shipper_telephone"
                                                    value="{{ old('shipper_telephone', isset($shipper) ? $shipper->shipper_telephone : '') }}"
                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shipper_extn">Ext.</label>
                                                <input type="text" id="shipper_extn" class="form-control"
                                                    name="shipper_extn"
                                                    value="{{ old('shipper_extn', isset($shipper) ? $shipper->shipper_extn : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shipper_fax">Fax</label>
                                                <input type="text" id="shipper_fax" class="form-control"
                                                    name="shipper_fax"
                                                    value="{{ old('shipper_fax', isset($shipper) ? $shipper->shipper_fax : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shipper_appointments">Appointments</label>
                                                <select id="shipper_appointments" class="form-control"
                                                    name="shipper_appointments">
                                                    <option value="Yes"
                                                        {{ old('shipper_appointments', isset($shipper) && $shipper->shipper_appointments == 'Yes' ? 'selected' : '') }}>
                                                        Yes</option>
                                                    <option value="No"
                                                        {{ old('shipper_appointments', isset($shipper) && $shipper->shipper_appointments == 'No' ? 'selected' : '') }}>
                                                        No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="shipper_status">Status <code>*</code></label>
                                                <select id="shipper_status" class="form-control" name="shipper_status"
                                                    required>
                                                    <option value="Active"
                                                        {{ old('shipper_status', isset($shipper) && $shipper->shipper_status == 'Active' ? 'selected' : '') }}>
                                                        Active</option>
                                                    <option value="In-Active"
                                                        {{ old('shipper_status', isset($shipper) && $shipper->shipper_status == 'In-Active' ? 'selected' : '') }}>
                                                        In-Active</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="shipper_shipping_notes">Shipping Notes</label>
                                                <textarea id="shipper_shipping_notes" class="form-control"
                                                    name="shipper_shipping_notes">{{ old('shipper_shipping_notes', isset($shipper) ? $shipper->shipper_shipping_notes : '') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="shipper_internal_notes">Internal Notes</label>
                                                <textarea id="shipper_internal_notes" class="form-control"
                                                    name="shipper_internal_notes">{{ old('shipper_internal_notes', isset($shipper) ? $shipper->shipper_internal_notes : '') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group d-flex">
                                                <input type="checkbox" id="same_as_consignee"
                                                name="same_as_consignee" class="mr-3">
                                                <label for="same_as_consignee" style="width:auto;">Same as consignee</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <button type="submit"
                                        class="btn btn-info">{{ isset($shipper) ? 'Save' : 'Add' }}</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><a
                                            class="text-white"
                                            href="https://crmcargoconvoy.co/shipper">Cancel</a></button>
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