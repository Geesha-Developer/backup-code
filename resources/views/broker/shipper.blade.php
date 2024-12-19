@extends('layouts.broker.app')
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check"></i>
  <h4 class="alert-heading"><b>Well done!</b></h4>
  <p>Shipper has been added Successfully!</p>
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
    .table>:not(caption)>*>* {
        background-color: unset !important;
    }
    button#hideFormButton {
        float: right;
    }
</style>
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
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
            <h2>Shipper Listing </h2>
        </div>

        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 p-0">
                    <div class="card">
                        <div class="body">

                            <div class="table-responsive">
                                <!-- <table class="table table-bordered table-hover dataTable js-exportable"> -->
                                <table class="table table-bordered js-basic-example dataTable" data-page-length="50">

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">ADD SHIPPER</button>


                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="margin-top: -10px;">
                                                    <button type="button" class="close" data-dismiss="modal" style="background: red;border-radius: 30px; padding: 0 5px; font-size: 22px;color: #fff;top: 30px;"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="POST" action="{{ route('shipper_insert') }}" id="myForm">
                                                    @csrf
                                                    <div class="card-header">
                                                        <h3 class="card-title">Add Shipper</h3>
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
                                                                        <select
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                                                                            class="form-control select2" required
                                                                            name="customer_country" id="country">
                                                                            <option style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;" value="">Choose Country</option>

                                                                            </option>
                                                                            @foreach($countries as $c)
                                                                            
                                                                            <option style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;" value="{{ $c->id }} {{ $c->name }}">{{$c->name}}
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
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
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
                                                                        style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Zip <code>*</code></label>
                                                                    <input type="text" class="form-control select2"
                                                                        required name="customer_zip" id="customer_zip"
                                                                        style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>POC Name</label>
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
                                                                    <input type="number" class="form-control" required name="shipper_telephone" style="width: 100%;">
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
                                                                        style="margin-bottom: 0;font-weight: 600;color: #4a4a4a;">Shipping
                                                                        Notes </label>
                                                                    <textarea class="form-control"
                                                                        name="shipper_shipping_notes"
                                                                        style="width: 100%;height: 100px !important;"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        style="margin-bottom: 0;font-weight: 600;color: #4a4a4a;">Internal
                                                                        Notes </label>
                                                                    <textarea class="form-control"
                                                                        name="shipper_internal_notes"
                                                                        style="width: 100%;height: 100px !important;"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <div class="modal-footer mt-4">
                                                        <input type="submit" class="btn btn-info" value="Save">
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
                                            <th>Shipper Name</th>
                                            <th>Address</th>
                                            <th>Phone No</th>
                                            <th>Added Date </th>
                                            <th>Agent</th>
                                            <th>Team Leader</th>
                                            <th>Manager</th>
                                            <th>Comment / Notes</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
                                        @foreach($fetch as $fetches)
                                        <tr>
                                            <td class="dynamic-data">{{ $i++ }}</td>
                                            <td class="dynamic-data">{{ $fetches->shipper_name }}</td>
                                            @php
                                            $countryName = explode(' ', $fetches->shipper_country, 2)[1] ?? '';
                                            @endphp

                                            <td class="dynamic-data">
                                                {{ $fetches->shipper_address }} {{ $countryName }} {{ $fetches->shipper_state }} {{ $fetches->shipper_city }} {{ $fetches->shipper_zip }}
                                            </td>
                                            <td class="dynamic-data">{{ $fetches->shipper_telephone }}</td>
                                            <td class="dynamic-data">{{ $fetches->created_at->format('m-d-Y') }}</td>
                                            <td class="dynamic-data">{{ $fetches->user->name }}</td>
                                            <td class="dynamic-data">{{ $fetches->user->team_lead }}</td>
                                            <td class="dynamic-data">{{ $fetches->user->manager }}</td>
                                            <td class="dynamic-data"><textarea disabled name="" id="" cols="40" rows="1"></textarea>
                                            <td class="dynamic-data">{{ $fetches->shipper_status }}</td>
                                            <td class="dynamic-data">
                                               <div class="d-flex">
                                                <a href="{{ route('shipper.edit', $fetches->id) }}"><i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i></a>
                                                    <!-- <form action="{{ route('shipper.delete.data', $fetches->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Shipper?');">
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