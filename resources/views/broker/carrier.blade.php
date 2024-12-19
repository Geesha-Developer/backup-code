@extends('layouts.broker.app')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check"></i>
  <h4 class="alert-heading"><b>Well done!</b></h4>
  <p>Carrier has been added Successfully!</p>
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
    label{
        margin-bottom: 0;
    font-weight: 600;
    text-align: left;
    font-size: 13px;
    color: #4a4a4a;
    font-family: poppins;
    }
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
    .edit-link {
    position: relative; /* Needed for positioning the disabled icon */
}

.disabled-icon {
    position: absolute;
    top: 0;
    left: 0;
    display: none; /* Initially hidden */
}

.edit-link.disabled {
    pointer-events: none; /* Disable interaction */
    color: gray; /* Change color to indicate it's disabled */
}
.row-open {
    background-color: #f9e79f !important; / Example color for Open /
}

.row-delivered {
    background-color: #ffcccb !important; / Example color for Delivered /
}
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Carrier Listing </h2>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a Class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab"
                            aria-controls="carriers" aria-selected="true"
                            style="font-size: 15px;color: #000;font-weight:500">My Carrier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"
                            aria-controls="carriers" aria-selected="true"
                            style="font-size: 15px;color: #000;font-weight:500">All Carrier</a>
                    </li>
                </ul>

                <div class="tab-content col-12" id="myTabContent">
                    <div class="tab-pane fade show active" id="dashboard" role="tabpanel"
                        aria-labelledby="customers-tab">
                        <div class="card">
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover js-basic-example dataTable" data-page-length="50">
                                   
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModal">ADD CARRIER</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('insert_carrier') }}"
                                                        id="myForm" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="card-header">
                                                            <h3 class="card-title">Add Carrier</h3>
                                                            <button type="button" class="close" style="background: red;border-radius: 30px; padding: 0 5px; font-size: 22px;color: #fff;"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>

                                                        <div class="card-body text-left">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Carrier Name <code>*</code></label>
                                                                        <input class="form-control select2" required name="carrier_name" style="width: 100%; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="mr-2">M.C. #/F.F.#
                                                                            <code>*</code></label>
                                                                        <div class="d-flex" style="width: 100%;">
                                                                            <select class="form-control select2 mr-2"
                                                                                required name="carrier_mc_ff"
                                                                                style="width: 35% !important;height:35px ">
                                                                                <option selected="selected" value="FF">
                                                                                    FF
                                                                                </option>
                                                                                <option selected="MC">MC</option>

                                                                            </select>
                                                                            <input type="text"
                                                                                class="form-control select2" required
                                                                                name="carrier_mc_ff_input"
                                                                                id="carrier_mc_ff_input"
                                                                                style="width: 65%; ">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label>D.O.T</label>
                                                                        <input class="form-control" name="carrier_dot"
                                                                            style="width: 100%; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Address<code>*</code></label>
                                                                        <input class="form-control" required
                                                                            name="carrier_address_two"
                                                                            style="width: 100%;  ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Country<code>*</code></label>
                                                                        <select
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                                                                            required class="form-control select2"
                                                                            name="carrier_country" id="country">
                                                                            <option
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                                value="">Choose Country</option>

                                                                            @foreach($countries as $c)
                                                                            <option
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;"
                                                                                value="{{$c->id}} {{ $c->name }}">
                                                                                {{$c->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>State<code>*</code></label>
                                                                        <div>
                                                                            <select
                                                                                style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 14px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                                                                                class="form-control select2"
                                                                                name="carrier_state" id="state"
                                                                                required>
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
                                                                        <input class="form-control" name="carrier_city"
                                                                            required style="width: 100%;  ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Zip<code>*</code></label>
                                                                        <input class="form-control" type="text"
                                                                            name="carrier_zip" required id="carrier_zip"
                                                                            style="width: 100%;  ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>POC Name</label>
                                                                        <input class="form-control"
                                                                            name="carrier_contact_name"
                                                                            style="width: 100%; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input class="form-control" name="carrier_email"
                                                                            style="width: 100%; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Phone No<code>*</code></label>
                                                                        <input type="number" class="form-control"
                                                                            name="carrier_telephone" required
                                                                            id="carrier_telephone"
                                                                            style="width: 100%; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Extn. </label>
                                                                        <input class="form-control" name="carrier_extn"
                                                                            style="width: 100%; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Fax</label>
                                                                        <input class="form-control" name="carrier_fax"
                                                                            style="width: 100%; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Status <code>*</code></label>
                                                                        <div class="select2-purple">
                                                                            <select class="form-control select2"
                                                                                name="carrier_status"
                                                                                style="width: 100%; " required>
                                                                                <option selected="selected">Select
                                                                                </option>
                                                                                <option
                                                                                    style="font-family: 'Poppins', sans-serif;">
                                                                                    Active</option>
                                                                                <option
                                                                                    style="font-family: 'Poppins', sans-serif;">
                                                                                    In-Active</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Payment Terms </label>
                                                                        <div class="select2-purple">
                                                                            <select class="form-control select2"
                                                                                name="carrier_payment_terms"
                                                                                style="width: 100%;  ">
                                                                                <option selected="selected">Select
                                                                                    Payment
                                                                                </option>
                                                                                <option
                                                                                    style="font-family: 'Poppins', sans-serif;">
                                                                                    Prepaid</option>
                                                                                <option
                                                                                    style="font-family: 'Poppins', sans-serif;">
                                                                                    Postpaid</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Factoring Company </label>
                                                                        <input class="form-control"
                                                                            name="carrier_factoring_company"
                                                                            style="width: 100%; ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            style="margin-bottom: 0; font-weight: 600;color: #4a4a4a;">Notes</label>
                                                                        <textarea class="form-control"
                                                                            name="carrier_notes"
                                                                            style="width: 100%; height: 70px !important"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            style="margin-bottom: 0; font-weight: 600;color: #4a4a4a;">File
                                                                            Upload</label>
                                                                        <input type="file" class="form-control"
                                                                            name="carrier_file_upload[]"
                                                                            id="carrier_file_upload" multiple
                                                                            style="width: 100%; height: 70px !important">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-4 mb-4 text-center">
                                                                <input type="submit" class="btn btn-info" value="Save"
                                                                    style="padding: 8px 40px;">
                                                                <input type="button" class="btn btn-danger"
                                                                    data-dismiss="modal" value="Cancel"
                                                                    style="font-size: 15px;padding: 8px 40px;">
                                                            </div>
                                                    </form>
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Carrier Name</th>
                                                        <th>MC No. / FF No.</th>
                                                        <th>DOT No</th>
                                                        <th>Address</th>
                                                        <th>Phone No.</th>
                                                        <th>Date Added</th>
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
                                                    @foreach($fetch as $fetches)
                                                    <tr class="load-row {{ $fetches->mc_check == 'Approved' ? 'row-open' : ($fetches->mc_check != 'Approved' ? 'row-delivered' : '') }}">
                                                        <td class="dynamic-data">{{ $i++ }}</td>
                                                        <td class="dynamic-data">{{ $fetches->carrier_name }}</td>
                                                        <td class="dynamic-data">{{ $fetches->carrier_mc_ff_input }}</td>
                                                        <td class="dynamic-data">{{ $fetches->carrier_dot }}</td>
                                                        @php
                                                        $countryName = explode(' ', $fetches->carrier_country, 2)[1] ??
                                                        '';
                                                        @endphp
                                                        <td class="dynamic-data">
                                                            {{ $fetches->carrier_address_two }} {{ $countryName }}
                                                            {{ $fetches->carrier_state }} {{ $fetches->carrier_city }}
                                                            {{ $fetches->carrier_zip }}
                                                        </td>
                                                        <td class="dynamic-data">{{ $fetches->carrier_telephone }}</td>
                                                        <td class="dynamic-data">{{ $fetches->created_at->format('Y-m-d') }}</td>
                                                        <td class="dynamic-data">{{ $fetches->user->name }}</td>
                                                        <td class="dynamic-data">{{ $fetches->user->team_lead }}</td>
                                                        <td class="dynamic-data">{{ $fetches->user->manager }}</td>
                                                        <td class="dynamic-data">
                                                            @if($fetches->mc_check == 'Approved')
                                                            Approved
                                                            @elseif($fetches->mc_check == 'Not Approved' ||
                                                            is_null($fetches->mc_check))
                                                            Pending For Approval
                                                            @endif
                                                        </td>
                                                        <td class="dynamic-data">
                                                            <div class="d-flex">
                                                            @if($fetches->mc_check != 'Approved')
                                                                <a href="{{ route('carriers.edit', $fetches->id) }}"><i
                                                                        class="fa fa-edit"
                                                                        style="font-size: 17px;color: #0dcaf0;"></i></a>
                                                            @else

                                                            -

                                                            @endif
                                                                <!-- <form
                                                                    action="{{ route('carrier.delete', $fetches->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure you want to delete this Carrier?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        style="border: none; background: none;">
                                                                        <i class="fa fa-trash"
                                                                            style="font-size: 17px; color: red;"></i>
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
                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="customers-tab">
                        
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#search-carrier">Search Carrier</button> -->
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover js-basic-example dataTable" data-page-length="50">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Carrier Name</th>
                                    <th>MC No. / FF No.</th>
                                    <th>Address</th>
                                    <th>Phone No.</th>
                                    <th>Team Leader</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                @endphp
                                @foreach($allcarrier as $all)
                                <tr class="load-row {{ $all->mc_check == 'Approved' ? 'row-open' : ($all->mc_check != 'Approved' ? 'row-delivered' : '') }}">
                                        <td class="dynamic-data">{{ $i++ }}</td>
                                        <td class="dynamic-data">{{ $all->carrier_name }}</td>
                                        <td class="dynamic-data">{{ $all->carrier_mc_ff_input }}</td>
                                        @php
                                            $countryName = explode(' ', $all->carrier_country, 2)[1] ?? '';
                                        @endphp
                                        <td class="dynamic-data">
                                            {{ $all->carrier_address_two }} {{ $countryName }}
                                            {{ $all->carrier_state }} {{ $all->carrier_city }} {{ $all->carrier_zip }}
                                        </td>
                                        <td class="dynamic-data">{{ $all->carrier_telephone }}</td>
                                        <td class="dynamic-data">{{ $all->user->team_lead }}</td>
                                        <td class="dynamic-data">
                                            @if($all->mc_check == 'Approved')
                                                Approved
                                            @else
                                                Pending For Approval
                                            @endif
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
</section>
<!-- <div class="modal" id="search-carrier">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Location Search <span style="color:red"><b>(Comming Soon)</b></span></h5>
                <button type="button" class="close" data-dismiss="modal" style="top: 30px !important;background: red;border-radius: 30px; padding: 0 5px; font-size: 22px;color: #fff;">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Pickup Location</label>
                            <input class="form-control" type="text" style="width: 100%;">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Drop Location</label>
                            <input class="form-control" type="text" style="width: 100%;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info" type="button" style="margin-top: 26px; width:100%;"><i class="fa fa-search"></i>Search</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="display:none;">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Load #</th>
                                    <th>W/O #</th>
                                    <th>Customer #</th>
                                    <th>Load Create Date</th>
                                    <th>Shipper Date</th>
                                    <th>Del Date</th>
                                    <th>Carrier</th>
                                    <th>Pickup Location</th>
                                    <th>Unloading Location</th>
                                </tr>
                            </thead>
                            <tbody>
            
                                <tr>
                                    <td class="dynamic-data">1</td>
                                    <td class="dynamic-data">2112</td>
                                    <td class="dynamic-data">213331</td>
                                    <td class="dynamic-data">3232224</td>
                                    <td class="dynamic-data">3232224</td>
                                    <td class="dynamic-data">3232224</td>
                                    <td class="dynamic-data">3232224</td>
                                    <td class="dynamic-data">3232224</td>
                                    <td class="dynamic-data">3232224</td>
                                    <td class="dynamic-data">3232224</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div> -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
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
    function deleteItem(id) {
        if (confirm("Are you sure you want to delete this item?")) {
            fetch(`/carrier/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })

                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Item deleted successfully');
                        location.reload();
                    } else {
                        alert('Error deleting item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting item');
                });
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Retrieve the last active tab from local storage
        var lastActiveTab = localStorage.getItem('lastActiveTab');

        // If a last active tab is found, set it as active
        if (lastActiveTab) {
            $('#myTab a[href="' + lastActiveTab + '"]').tab('show');
        }

        // Store the active tab in local storage when a tab is clicked
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetTab = e.target.getAttribute('href');
            localStorage.setItem('lastActiveTab', targetTab);
        });

        // Initialize DataTables for both tables
        $('#dataTableOpen').DataTable();
        $('#dataTableDelivered').DataTable();
    });
</script>

<script>
$(document).ready(function() {
    $('.edit-link').hover(
        function() {
            $(this).addClass('disabled');
            $(this).find('.disabled-icon').show(); // Show the disabled icon
        }, 
        function() {
            $(this).removeClass('disabled');
            $(this).find('.disabled-icon').hide(); // Hide the disabled icon
        }
    );
});
</script>


@endsection