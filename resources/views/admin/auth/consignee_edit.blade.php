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
<div class="card-body text-left">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Name <code>*</code></label>
                                                                    <input class="form-control" name="consignee_name"
                                                                        required style="width: 100%;" value="{{ $consignee->consignee_name }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Address <code>*</code></label>
                                                                    <input class="form-control" name="consignee_address" required value="{{ $consignee->consignee_address }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Country <code>*</code></label>
                                                                    <div>
                                                                        <select class="form-control select2" required required name="consignee_country" id="country"> 
                                                                            <option style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;" value="" class="hiddenOption">Choose Country
                                                                            </option>

                                                                            @foreach($countries as $c)
                                                                            <option value="{{ $c->id }} {{ $c->name }}" data-name="{{ $c->name }}"> {{ $c->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>State <code>*</code></label>
                                                                    <div>
                                                                        <select class="form-control select2" required
                                                                            name="consignee_state" id="state">
                                                                            <option value="">Please Select</option>
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
                                                                    <input class="form-control" required
                                                                        name="consignee_city" value="{{ $consignee->consignee_city }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Zip <code>*</code></label>
                                                                    <input type="number" class="form-control" required
                                                                        name="consignee_zip"  value="{{ $consignee->consignee_zip }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Major Intersections</label>
                                                                    <input class="form-control" name="consignee_major_intersections"  value="{{ $consignee->consignee_major_intersections }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Status <code>*</code></label>
                                                                    <select class="form-control" required
                                                                        name="consignee_status"
                                                                        style="width: 100%;height: 35px;padding: 1px">
                                                                        <option selected="selected">{{ $consignee->consignee_status }}</option>
                                                                        <option value="Active">Active</option>
                                                                        <option value="In-Active">In-Active</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>POC Name</label>
                                                                    <input class="form-control" name="consignee_contact_name" value="{{ $consignee->consignee_contact_name }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Contact Email</label>
                                                                    <input class="form-control" name="consignee_contact_email" value="{{ $consignee->consignee_contact_email }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Telephone <code>*</code></label>
                                                                    <input type="number" class="form-control" required name="consignee_telephone" value="{{ $consignee->consignee_telephone }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Ext. </label>
                                                                    <input class="form-control" name="consignee_ext" value="{{ $consignee->consignee_ext }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Toll Free</label>
                                                                    <input class="form-control" name="consignee_toll_free" value="{{ $consignee->consignee_toll_free }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Fax</label>
                                                                    <input class="form-control" name="consignee_fax" value="{{ $consignee->consignee_fax }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Consignee Hours</label>
                                                                    <input type="time" class="form-control" name="consignee_hours" value="{{ $consignee->consignee_hours }}" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Appointments</label>
                                                                    <select class="form-control select2"
                                                                        name="consignee_appointments"
                                                                        style="width: 100%;">
                                                                        <option selected="selected" value="{{ $consignee->consignee_appointments }}">{{ $consignee->consignee_appointments }}</option>
                                                                        <option>No</option>
                                                                        <option>Yes</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
        
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Internal Notes </label>
                                                                    <textarea class="form-control"
                                                                        name="consignee_internal_notes" style="width: 100%;height: 100px !Important">{{ $consignee->consignee_internal_notes }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Shipping Notes </label>
                                                                    <textarea class="form-control"
                                                                        name="consignee_shipping_notes" 
                                                                        style="width: 100%;height: 100px !Important">{{ $consignee->consignee_shipping_notes }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="text" name="added_by_user"
                                                            value="{{ $consignee->user->name }}" readonly hidden>

                                                    </div>
                                                    <div class="text-center mt-4">
                                                        <input type="submit" class="btn btn-info" value="Save"
                                                            onclick="saveFormData()">
                                                       <button type="button" class="btn btn-danger"><a href="https://crmcargoconvoy.co/consignee" class="text-white">Cancel</a></button>
                                                    </div>
</section>
@endsection