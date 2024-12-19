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
<style>
    .table>:not(caption)>*>* {
        background-color: unset !important;
    }
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2><b>Carrier Data</b>  </h2>
        </div>

        <div class="container-fluid p-0">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <div class="">
                                <!-- <table class="table table-bordered table-responsive dataTable no-footer"> -->
                            
                                <div class="table-responsive">
                                    <table class="table table-bordered dataTable no-footer" id="dataTable">

                                        <thead>
                                            <tr>
                                                <th style="color: #fff !important;">Broker Case</th>
                                                <th style="color: #fff !important;">Carrier Name</th>
                                                <th style="color: #fff !important;">Carrier Contact Name</th>
                                                <th style="color: #fff !important;">Carrier Email</th>
                                                <th style="color: #fff !important;">Carrier Telephone</th>
                                                <th style="color: #fff !important;">Carrier Username</th>
                                                <th style="color: #fff !important;">Carrier Password</th>
                                                <th style="color: #fff !important;">Carrier Status</th>
                                                <th style="color: #fff !important;">Carrier Payment Terms</th>
                                                <th style="color: #fff !important;">Carrier Load Type</th>
                                                <th style="color: #fff !important;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($external as $externals)
                                            <tr>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->user->name }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->carrier_name }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->carrier_contact_name }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->carrier_email }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->carrier_telephone }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->carrier_username }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->carrier_password }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->carrier_status }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->carrier_payment_terms }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $externals->carrier_load_type }}</td>
                                                <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">
                                                <a href="{{ route('carrier.data', $externals->id) }}" onclick="deleteExternal({{ $externals->id }})">
                                                <i class="fas fa-trash" style="color: red;"></i></a>



                                                <a href="{{ route('edit.customer', ['id' => $externals->id]) }}"><i
                                                            class="fas fa-pen" style="color: #222222;"></i></a>
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