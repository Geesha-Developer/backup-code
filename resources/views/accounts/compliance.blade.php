@extends('layouts.accounts.app')

@section('content')

<style>
    thead#sticky {
    position: fixed;
    top: 0px;
    z-index: 1000;
    box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    /* background-color: white; */
}
.table>:not(caption)>*>* {
        background-color: unset !important;
    }
</style>
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
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important;">
            <h2><b>Compliance Data</b></h2>
        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="card">
                    <div class="container-fluid">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="myTab">
                            <li class="nav-item">
                                <a class="nav-link active" id="delivered-tab" data-bs-toggle="tab" role="tab"
                                    aria-controls="delivered" aria-selected="true" style="font-size:15px;"
                                    href="#home_with_icon_title">
                                    <i class="fas fa-shipping-fast"></i> MC Check
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="completed-tab" data-bs-toggle="tab" role="tab"
                                    aria-controls="completed" aria-selected="false"
                                    style="font-size:15px;" href="#profile_with_icon_title">
                                    <i class="fa fa-check"></i> CPR Check
                                </a>
                            </li>
                        </ul>



                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active col-12 p-0" id="home_with_icon_title">
                                <div class="body p-0">

                                   <div class="table-responsive">
                                        <table class="table table-bordered dataTable no-footer" data-page-length="50" id="dataTable">
                                        
                                                <thead>
                                                <tr>
                                                    <th>MC NO</th>
                                                    <th>DOT</th>
                                                    <th>Carrier Name</th>
                                                    <th>Agent</th>
                                                    <th>Added Date</th>
                                                    <th>MC Check</th>
                                                    <th>MC Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = 1;
                                                // Get the latest created_at date from the collection
                                                $latestDate = $carrier->max('created_at');
                                                @endphp
                                                @foreach($carrier as $c)
                                                <tr style="background-color: {{ $c->created_at == $latestDate ? '#ACD3FE' : 'transparent' }};">
                                                   
                                                    <td class="dynamic-data">
                                                        {{ $c->carrier_mc_ff_input }}</td>
                                                        <td class="dynamic-data">
                                                        {{ $c->carrier_dot }}
                                                    </td>
                                                    <td class="dynamic-data">
                                                        {{ $c->carrier_name }}
                                                    </td>
                                                    <td class="dynamic-data">
                                                        {{ $c->user->name }}
                                                    </td>
                                                    <td class="dynamic-data">
                                                        {{ $c->created_at ? \Carbon\Carbon::parse($c->created_at)->format('m-d-Y') : '' }}
                                                    </td>
                                                    <td class="dynamic-data">
                                                        <select name="mc_check" id="mc_check-{{ $c->id }}" data-load-id="{{ $c->id }}">
                                                            <option value=""> Select MC</option>
                                                            <option value="Approved" {{ $c->mc_check == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                            <option value="Not Approved" {{ $c->mc_check == 'Not Approved' ? 'selected' : '' }}>Not Approved</option>
                                                        </select>
                                                    </td>
                                                    
                                                    @if($c->mc_check == 'Approved')
                                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important; color: green;">
                                                        Approved</td>
                                                    @else
                                                    <td class="dynamic-data"
                                                        style="padding: 7px 10px !important; vertical-align: middle !important; color: red;  font-weight: 600 !important;">
                                                        Not Approved </td>
                                                    @endif

                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile_with_icon_title">
                                <div class="body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered dataTable no-footer" id="cpr" data-page-length="50">
                                    
                                            <thead>
                                                <tr>
                                                    <th>Load #</th>
                                                    <th>W/O #</th>
                                                    <th>Agent</th>
                                                    <th>Customer #</th>
                                                    <th>Customer Final Rate</th>
                                                    <th>Office</th>
                                                    <th>Team Leader</th>
                                                    <th>Manager</th>
                                                    <th>Load Create Date</th>
                                                    <th>Shipper Date</th>
                                                    <th>Delivery Date</th>
                                                    <th>Equipment Type</th>
                                                    <th>Carrier Name</th>
                                                    <th>Carrier Final Rate</th>
                                                    <th>Pickup Location</th>
                                                    <th>Unloading Location</th>
                                                    <th>Load Status</th>
                                                    <!-- <th>Micro Point</th> -->
                                                    <th>CPR</th>
                                                    <th>Macro</th>
                                                    <th>No Of Macro</th>
                                                    <th>CPR Status</th>
                                                    <th>Documents</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = 1;
                                                $latestDate = $loads->max('created_at');
                                                @endphp
                                                @foreach($loads as $delivered)
                                                <tr style="background-color: {{ $delivered->created_at == $latestDate ? '#ACD3FE' : 'transparent' }};">
                                                    
                                                    <td class="dynamic-data">
                                                        <a style="color: rgb(10 185 90) !important;font-weight: 700;" href="#" onclick="openUploadWindow('{{ route('accounting.load.edit', $delivered->id) }}'); return false;" style="text-decoration: unset;">
                                                            {{ $delivered->load_number }}
                                                        </a>
                                                    </td>
                                                    <td class="dynamic-data">{{ $delivered->load_workorder }}</td>
                                                    <td class="dynamic-data">{{ $delivered->user->name }}</td>
                                                    <td class="dynamic-data">{{ $delivered->load_bill_to }}</td>
                                                    <td class="dynamic-data">{{ $delivered->shipper_load_final_rate }}</td>
                                                    <td class="dynamic-data">{{ $delivered->user->office }}</td>
                                                    <td class="dynamic-data">{{ $delivered->user->team_lead }}</td>
                                                    <td class="dynamic-data">{{ $delivered->user->manager }}</td>
                                                    <td class="dynamic-data">{{ $delivered->created_at->format('m-d-Y') }}</td>
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
                                                    <td class="dynamic-data">
                                                        {{ 
                                                            isset($consignee_appointment[0]['appointment']) && 
                                                            \Carbon\Carbon::hasFormat($consignee_appointment[0]['appointment'], 'm-d-Y\TH:i:s') 
                                                                ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                                                : '' 
                                                        }}
                                                    </td>

                                                    <td class="dynamic-data">{{ $delivered->load_equipment_type }}</td>
                                                    <td class="dynamic-data">{{$delivered->load_carrier}}</td>
                                                    <td class="dynamic-data">{{$delivered->load_final_carrier_fee}}</td>
                                                    @php
                                                    $shipper_location = json_decode($delivered->load_shipper_location, true);
                                                    @endphp

                                                        <td class="dynamic-data" >
                                                            {{ $shipper_location[0]['location'] ?? '' }}
                                                        </td>
                                                    @php
                                                    $consignee_location = json_decode($delivered->load_consignee_location, true);
                                                    $last_consignee_location = is_array($consignee_location) && !empty($consignee_location) ? end($consignee_location) : null;
                                                    @endphp

                                                    
                                                    @if (!empty($last_consignee_location) && is_array($last_consignee_location))
                                                        <td class="dynamic-data">
                                                            {{ $last_consignee_location['location'] ?? '' }}
                                                        </td>
                                                    @else
                                                        <td>
                                                            Not Found Any Drop Location
                                                        </td>
                                                    @endif
                                                    
                                                   
                                                    <td class="dynamic-data"
                                                        >
                                                        {{ $delivered->load_status }}
                                                    </td>
                                                    <!-- <td>
                                                        <select name="micro_point" id="micro_point">
                                                            <option value="">Select Micro Point</option>
                                                            <option value=""></option>
                                                            <option value=""></option>
                                                        </select>
                                                    </td> -->
                                                    <td class="dynamic-data" >
                                                        <select name="cpr_check" id="cpr_check-{{ $delivered->id }}" data-load-id="{{ $delivered->id }}">
                                                            <option value=""> Select CPR</option>
                                                            <option value="Verified" {{ $delivered->cpr_check == 'Verified' ? 'selected' : '' }}>Verified</option>
                                                            <option value="Not Verified" {{ $delivered->cpr_check == 'Not Verified' ? 'selected' : '' }}>Not Verified</option>
                                                            <option value="Not Received" {{ $delivered->cpr_check == 'Not Received' ? 'selected' : '' }}>Not Received</option>
                                                        </select>
                                                    </td>
                                                    <td class="dynamic-data" >
                                                        <select name="macro" id="macro-{{ $delivered->id }}" data-load-id="{{ $delivered->id }}">
                                                            <option value="">Select Macro</option>
                                                            <option value="Sent" {{ $delivered->macro == 'Sent' ? 'selected' : '' }}>Sent</option>
                                                            <option value="Not Sent" {{ $delivered->macro == 'Not Sent' ? 'selected' : '' }}>Not Sent</option>
                                                        </select>
                                                    </td>
                                                    <td class="dynamic-data" >
                                                        <select name="no_of_macro" id="no_of_macro-{{ $delivered->id }}" data-load-id="{{ $delivered->id }}">
                                                            <option value="">Select No Of Macro</option>
                                                            @for ($i = 1; $i <= 10; $i++)
                                                                <option value="{{ $i }}" {{ $delivered->no_of_macro == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>

                                                    @if($delivered->cpr_check == 'Verified')
                                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;color: green;">
                                                    Verified
                                                    </td>
                                                    @elseif($delivered->cpr_check == 'Not Verified')
                                                    <td class="dynamic-data" >
                                                        Not Verified
                                                    </td>
                                                    @elseif($delivered->cpr_check == 'Not Received')
                                                    <td class="dynamic-data" >
                                                        Not Received
                                                    </td>
                                                    @elseif($delivered->cpr_check != 'Verified')
                                                    <td class="dynamic-data" >
                                                         Check CPR
                                                    </td>
                                                    @endif
                                                    <td class="dynamic-data">
                                                    
                                                    @if (!empty($delivered->load_delivery_do_file))
                                                            @php
                                                                $fileUrl = asset('storage/' . $delivered->load_delivery_do_file);
                                                            @endphp
                                                            <a href="{{ $fileUrl }}" target="_blank"><i class="fa fa-eye" style="font-size: 15px;color: #000; margin-right: 6px;"></i></a> | 
                                                            <a href="{{ $fileUrl }}" download><i class="fa fa-download" style="font-size: 15px;color: #000; margin-left: 6px;"></i></a>
                                                        @else
                                                            No File Available
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
            </div>
        </div>
    </div>
</section>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
    // Listen for changes on mc_check select elements
    $('select[id^="mc_check-"]').on('change', function () {
        var loadId = $(this).data('load-id');
        var mcCheck = $(`#mc_check-${loadId}`).val();

        $.ajax({
            url: '{{ route("saveCarrierChecks") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: loadId,
                mc_check: mcCheck
            },
            success: function (response) {
                alert('MC Check updated successfully.');
                // location.reload();
            },
            error: function (response) {
                alert('An error occurred while updating the MC Check.');
            }
        });
    });

    // Listen for changes on cpr_check select elements
    $('select[id^="cpr_check-"]').on('change', function () {
        var loadId = $(this).data('load-id');
        var cprCheck = $(`#cpr_check-${loadId}`).val();

        $.ajax({
            url: '{{ route("savecprChecks") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: loadId,
                cpr_check: cprCheck
            },
            success: function (response) {
                alert('CPR Check updated successfully.');
                // location.reload();
            },
            error: function (response) {
                alert('An error occurred while updating the CPR Check.');
            }
        });
    });

    // Check the initial state of mc_check fields
    $('select[id^="mc_check-"]').each(function () {
        var loadId = $(this).data('load-id');
        var mcCheck = $(this).val();
        if (mcCheck === 'Approved') {
            $(`#cpr_check-${loadId}`).prop('disabled', false);
        } else {
            $(`#cpr_check-${loadId}`).prop('disabled', true);
        }
    });
});
</script>
<script>
    $(document).ready(function() {
    $('select[name="macro"], select[name="no_of_macro"]').change(function() {
        var loadId = $(this).data('load-id');
        var macro = $('#macro-' + loadId).val();
        var noOfMacro = $('#no_of_macro-' + loadId).val();

        $.ajax({
            url: "{{ route('load.updateMacro') }}",  // Update with the correct route name
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                load_id: loadId,
                macro: macro,
                no_of_macro: noOfMacro
            },
            success: function(response) {
                alert('Macro and No of Macro updated successfully!');
                // location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error updating Macro and No of Macro: ' + error);
            }
        });
    });
});

</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JavaScript library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

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

<script>
    $(document).ready(function() {
        // Initialize DataTable for #cpr
        var tableCpr = $('#cpr').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'btn btn-success'
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-success'
                },
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'btn btn-success'
                },
                {
                    extend: 'copy',
                    text: 'Copy',
                    className: 'btn btn-success'
                }
            ],
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
        $('#dataTable').DataTable({
            // You can add options here, for example:
            // "paging": true,
            // "ordering": true,
            // "info": true,
            // "searching": true // This is enabled by default
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

@endsection