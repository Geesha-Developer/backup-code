@extends('layouts.broker.app')
@section('content')

<style>
    .table>:not(caption)>*>* {
        background-color: unset !important;
    }
    button#hideFormButton {
        float: right;
    }

    .modal .modal-header .close {
        color: #000000;
        top: 26px;
    }
</style>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check"></i>
  <h4 class="alert-heading"><b>Well done!</b></h4>
  <p>Consignee has been added Successfully!</p>
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


<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>Consignee Listing</h2>
        </div>

        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 p-0">
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered js-basic-example dataTable" data-page-length="50">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        ADD CONSIGNEE
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" style="background: red;border-radius: 30px; padding: 0 5px; font-size: 22px;color: #fff;"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="POST" action="{{ route('consignee.data.post') }}"
                                                    id="myForm">
                                                    @csrf
                                                    <div class="card-header"
                                                        style="background-color: #435d7d;color: #fff;">
                                                        <h3 class="card-title">Add Consignee</h3>
                                                    </div>

                                                    <div class="card-body text-left">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Name <code>*</code></label>
                                                                    <input class="form-control" name="consignee_name"
                                                                        required style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Address <code>*</code></label>
                                                                    <input class="form-control" name="consignee_address" required
                                                                        style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Country <code>*</code></label>
                                                                    <div>
                                                                        <select class="form-control select2" required name="consignee_country" id="country">
                                                                            <option style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;" value="">Choose Country</option>

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
                                                                            <option selected="selected">Please Select
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
                                                                    <input class="form-control" required
                                                                        name="consignee_city" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Zip <code>*</code></label>
                                                                    <input type="text" class="form-control" required
                                                                        name="consignee_zip" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Major Intersections</label>
                                                                    <input class="form-control"
                                                                        name="consignee_major_intersections"
                                                                        style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Status <code>*</code></label>
                                                                    <select class="form-control" required
                                                                        name="consignee_status"
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
                                                                    <label>POC Name</label>
                                                                    <input class="form-control"
                                                                        name="consignee_contact_name"
                                                                        style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Contact Email</label>
                                                                    <input class="form-control"
                                                                        name="consignee_contact_email"
                                                                        style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Telephone</label>
                                                                    <input type="number" class="form-control"
                                                                        name="consignee_telephone" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Ext. </label>
                                                                    <input class="form-control" name="consignee_ext"
                                                                        style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Toll Free</label>
                                                                    <input class="form-control"
                                                                        name="consignee_toll_free" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Fax</label>
                                                                    <input class="form-control" name="consignee_fax"
                                                                        style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Consignee Hours</label>
                                                                    <input type="time" class="form-control"
                                                                        name="consignee_hours" style="width: 100%;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Appointments</label>
                                                                    <select class="form-control select2"
                                                                        name="consignee_appointments"
                                                                        style="width: 100%;">
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
                                                                        <label class="one-line-label mr-2"
                                                                            style="white-space: nowrap;">Add as
                                                                            Shipper</label>
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="consignee_add_shippper"
                                                                            id="consignee_add_shippper"
                                                                            style="margin-left: -15px;width: 15%;height: 30px;margin-top: 0;"
                                                                            value="1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6">
                                                                <div class="form-group1">
                                                                    <label>Internal Notes </label>
                                                                    <textarea class="form-control"
                                                                        name="consignee_internal_notes"
                                                                        style="width: 100%;height: 61px;"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6">
                                                                <div class="form-group1">
                                                                    <label>Shipping Notes </label>
                                                                    <textarea class="form-control"
                                                                        name="consignee_shipping_notes"
                                                                        style="width: 100%;height: 61px;"></textarea>
                                                                </div>
                                                            </div>

                                                           
                                                        </div>
                                                        <input type="text" name="added_by_user"
                                                            value="{{ Auth::user()->name }}" readonly hidden>

                                                    </div>
                                                    <div class="modal-footer mt-4">
                                                        <input type="submit" class="btn btn-info" value="Save"
                                                            onclick="saveFormData()">
                                                         <input type="button" style="font-size:14px !important;"  class="btn btn-warning" id="clearFormButton" Value="Clear Form">
                                                        <input type="button" class="btn btn-danger" data-dismiss="modal"
                                                            value="Cancel">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Consignee Name</th>
                                            <th>Address</th>
                                            <th>Phone No</th>
                                            <th>Added Date</th>
                                            <th>Agent</th>
                                            <th>Team Leader</th>
                                            <th>Manager</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach($consignees as $consigne)
                                        <tr>
                                            <td class="dynamic-data">{{ $i++ }}</td>
                                            <td class="dynamic-data">{{ $consigne->consignee_name }}</td>
                                            @php
                                            $countryName = explode(' ', $consigne->consignee_country, 2)[1] ?? '';
                                            @endphp

                                            <td class="dynamic-data">
                                                {{ $consigne->consignee_address }} {{ $countryName }} {{ $consigne->consignee_state }} {{ $consigne->consignee_city }} {{ $consigne->consignee_zip }}
                                            </td>
                                            <td class="dynamic-data">{{ $consigne->consignee_telephone }}</td>
                                            
                                            <td class="dynamic-data">{{ $consigne->created_at->format('m-d-y') }}</td>
                                            <td class="dynamic-data">{{ $consigne->user->name }}</td>
                                            <td class="dynamic-data">{{ $consigne->user->team_lead }}</td>
                                            <td class="dynamic-data">{{ $consigne->user->manager }}</td>
                                            <td class="dynamic-data">{{ $consigne->consignee_status }}</td>
                                            <td class="dynamic-data">
                                                <div class="d-flex">
                                                    <a href="{{ route('consignees.edit', $consigne->id) }}">
                                                        <i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i>
                                                    </a>
                                                    <!-- <form action="{{ route('consignee.delete', $consigne->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Consignee?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="border: none; background: none;">
                                                            <i class="fa fa-trash" style="font-size: 17px; color: red;"></i>
                                                        </button>
                                                    </form> -->
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
</section>

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
    // Function to clear all form data
    function clearFormData() {
        $('#myForm')[0].reset(); // Reset the form
    }
// Clear form button click event
    $('#clearFormButton').on('click', function() {
        clearFormData(); // Call the clear form function
    });
});
</script>
@endsection