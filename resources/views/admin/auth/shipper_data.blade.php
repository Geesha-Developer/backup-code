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
    <div class="body_scroll">
        <div class="block-header">
           <h2><b>Shipper Data</b> </h2>
        </div>

        <div class="container-fluid p-0">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                       
                            <div class="table-responsive">
                                <!-- <table class="table table-bordered table-responsive dataTable no-footer"> -->
                                <table class="table table-bordered table-responsive dataTable no-footer" id="dataTable">

                                    <thead>
                                        <tr>
                                            <th style="color: #fff !important;">Sr No.</th>
                                            <th style="color: #fff !important;">Broker Name</th>
                                            <th style="color: #fff !important;">Shipper Name</th>
                                            <th style="color: #fff !important;">Shipper Address</th>
                                            <th style="color: #fff !important;">Shipper Contact Name</th>
                                            <th style="color: #fff !important;">Shipper Contact Email</th>
                                            <th style="color: #fff !important;">Shipper Telephone</th>
                                            <th style="color: #fff !important;">Shipper Hours</th>
                                            <th style="color: #fff !important;">Shipper Appointment</th>
                                            <th style="color: #fff !important;">Shipper Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach($shipper as $shippers)
                                        <tr>
                                            <td class="dynamic-data">{{ $i++ }}</td>
                                            <td class="dynamic-data">{{ $shippers->user->name }}</td>
                                            <td class="dynamic-data">{{ $shippers->shipper_name }}</td>
                                            <td class="dynamic-data">{{ $shippers->shipper_address}}</td>
                                            <td class="dynamic-data">{{ $shippers->shipper_contact_name}}</td>
                                            <td class="dynamic-data">{{ $shippers->shipper_contact_email }}</td>
                                            <td class="dynamic-data">{{ $shippers->shipper_telephone }}</td>
                                            <td class="dynamic-data">{{ $shippers->shipper_hours }}</td>
                                            <td class="dynamic-data">{{ $shippers->shipper_appointments }}</td>
                                            <td class="dynamic-data">{{ $shippers->shipper_status }}</td>
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
@endsection
