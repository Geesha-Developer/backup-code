@extends('layouts.broker.app')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check"></i>
  <h4 class="alert-heading"><b>Well done!</b></h4>
  <p>Your Carrier has been edit Successfully!</p>
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
    button.close {
        position: absolute;
        right: 14px;
        color: #000;
        top: 8px !important;
        font-size: 32px;
    }

    button#hideFormButton {
        float: right;
    }
</style>

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>Carrier Listing</h2>
        </div>

        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 p-0">
                    <div class="card">
                        <div class="body">
                            <form method="POST" action="{{ route('carriers.update', $carrier->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body text-left">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Carrier Name <code>*</code></label>
                                                <input type="text" class="form-control" name="carrier_name"
                                                    value="{{ $carrier->carrier_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>M.C. #/F.F. # <code>*</code></label>
                                                <div class="d-flex">
                                                    <select class="form-control" name="carrier_mc_ff" required>
                                                        <option value="FF"
                                                            {{ $carrier->carrier_mc_ff === 'FF' ? 'selected' : '' }}>FF
                                                        </option>
                                                        <option value="MC"
                                                            {{ $carrier->carrier_mc_ff === 'MC' ? 'selected' : '' }}>MC
                                                        </option>
                                                    </select>
                                                    <input type="text" class="form-control" name="carrier_mc_ff_input"
                                                        value="{{ $carrier->carrier_mc_ff_input }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>D.O.T</label>
                                                <input type="text" class="form-control" name="carrier_dot"
                                                    value="{{ $carrier->carrier_dot }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Address<code>*</code></label>
                                                <input type="text" class="form-control" required name="carrier_address_two"
                                                    value="{{ $carrier->carrier_address_two }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Country<code>*</code></label>
                                                <select
                                                    style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                                                    class="form-control select2" name="carrier_country" id="country">
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
                                                <label>City<code>*</code></label>
                                                <input type="text" class="form-control" name="carrier_city" required
                                                    value="{{ $carrier->carrier_city }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Zip<code>*</code></label>
                                                <input type="text" class="form-control" name="carrier_zip" required
                                                    value="{{ $carrier->carrier_zip }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>POC Name</label>
                                                <input type="text" class="form-control" name="carrier_contact_name"
                                                    value="{{ $carrier->carrier_contact_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="carrier_email"
                                                    value="{{ $carrier->carrier_email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Telephone<code>*</code></label>
                                                <input type="number" class="form-control" name="carrier_telephone" required
                                                    value="{{ $carrier->carrier_telephone }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Extn.</label>
                                                <input type="text" class="form-control" name="carrier_extn"
                                                    value="{{ $carrier->carrier_extn }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Fax</label>
                                                <input type="text" class="form-control" name="carrier_fax"
                                                    value="{{ $carrier->carrier_fax }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Status <code>*</code></label>
                                                <select class="form-control" name="carrier_status" required>
                                                    <option value="" disabled selected>Select Status</option>
                                                    <option value="Active"
                                                        {{ $carrier->carrier_status === 'Active' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="Inactive"
                                                        {{ $carrier->carrier_status === 'Inactive' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Payment Terms</label>
                                                <select class="form-control" name="carrier_payment_terms">
                                                    <option value="" disabled selected>Select Payment Terms</option>
                                                    <option value="Prepaid"
                                                        {{ $carrier->carrier_payment_terms === 'Prepaid' ? 'selected' : '' }}>
                                                        Prepaid</option>
                                                    <option value="Postpaid"
                                                        {{ $carrier->carrier_payment_terms === 'Postpaid' ? 'selected' : '' }}>
                                                        Postpaid</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Factoring Company</label>
                                                <input type="text" class="form-control" name="carrier_factoring_company"
                                                    value="{{ $carrier->carrier_factoring_company }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Notes</label>
                                                <textarea class="form-control" name="carrier_notes"  style="height:100px !important;"
                                                    rows="3">{{ $carrier->carrier_notes }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File Upload</label>
                                                <input type="file" class="form-control" name="carrier_file_upload[]" style="height:100px !important;"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <button type="submit" class="btn btn-info">Save</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><a class="text-white" href="https://crmcargoconvoy.co/carrier">Cancel</a></button>
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