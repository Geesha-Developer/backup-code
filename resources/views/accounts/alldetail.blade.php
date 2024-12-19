@extends('layouts.accounts.app')
@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important;">
            <h2><b>Carrier And Customer Data</b></h2>
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
                                   href="#home_with_icon_title">Carriers Data
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="completed-tab" data-bs-toggle="tab" role="tab"
                                   aria-controls="completed" aria-selected="false"
                                   style="font-size:15px;" href="#profile_with_icon_title"> Customers Data
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active col-12 p-0" id="home_with_icon_title">
                                <div class="body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered dataTable" id="carrierDataTable" data-page-length="50">
                                            <thead>
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>Agent</th>
                                                    <th>MC #</th>
                                                    <th>Carrier Name</th>
                                                    <th>DOT #</th>
                                                    <th>Carrier Address</th>
                                                    <th>Carrier Contact Person</th>
                                                    <th>Carrier Email</th>
                                                    <th>Carrier Telephone</th>
                                                    <th>Carrier Payment Terms</th>
                                                    <th>Carrier Factoring Company</th>
                                                    <th>Carrier Notes</th>
                                                    <th>Carrier Status</th>
                                                    <th>MC Check Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 1; @endphp
                                                @foreach($carrier as $c)
                                                    <tr>
                                                        <td class="dynamic-data">{{ $i++ }}</td>
                                                        <td class="dynamic-data">{{ $c->user->name }}</td> <!-- Access the user's name -->                                                 
                                                        <td class="dynamic-data">{{ $c->carrier_mc_ff_input }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_name }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_dot }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_address_two }} {{ $c->carrier_state }} {{ $c->carrier_city }}  {{ preg_replace('/^\d+\s*/', '', $c->carrier_country) }} {{ $c->carrier_zip }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_contact_name }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_email }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_telephone }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_payment_terms }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_factoring_company }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_notes }}</td>
                                                        <td class="dynamic-data">{{ $c->carrier_status }}</td>
                                                        <td class="dynamic-data">{{ $c->mc_check }}</td>
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
                                        <table class="table table-bordered dataTable" id="customerDataTable" data-page-length="50">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Agent Name</th>
                                                    <th>Customer Name</th>
                                                    <th>Address</th>
                                                    <th>Telephone</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 1; @endphp
                                                @foreach($customers as $cst)
                                                    <tr>
                                                        <td class="dynamic-data">{{ $i++ }}</td>
                                                        <td class="dynamic-data">{{ $cst->user->name }}</td> <!-- Access the user's name -->                                                 
                                                        <td class="dynamic-data">{{ $cst->customer_name }}</td>
                                                        <td class="dynamic-data">{{ $cst->customer_address }} {{ $cst->customer_city }} {{ $cst->customer_state}} {{ $cst->customer_zip }} {{ preg_replace('/^\d+\s*/', '', $cst->customer_country) }}</td>
                                                        <td class="dynamic-data">{{ $cst->customer_telephone }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End of tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Required JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- Initialize DataTables for both tables -->
<script>
    $(document).ready(function() {
        // Initialize the first table (Carrier Data Table)
        $('#carrierDataTable').DataTable({
            "pageLength": 50,
            "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Dropdown for entries per page
            "responsive": true,
            "ordering": true,
            "searching": true
        });

        // Initialize the second table (Customer Data Table)
        $('#customerDataTable').DataTable({
            "pageLength": 50,
            "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
            "responsive": true,
            "ordering": true,
            "searching": true
        });

        // Tab Activation from localStorage
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
        } else {
            $('.nav-tabs a:first').tab('show');
        }

        $('.nav-tabs a').on('click', function () {
            var tabId = $(this).attr('href');
            localStorage.setItem('activeTab', tabId);
        });

        // Row Highlighting Script
        var style = '<style>' +
                        'tbody tr.highlight-row {' +
                            'background-color: #CAF1EB !important;' +
                        '}' +
                    '</style>';
        $('head').append(style);

        // Event delegation for row highlighting
        $('tbody').on('click', 'td', function() {
            $('tbody tr').removeClass('highlight-row');
            $(this).closest('tr').addClass('highlight-row');
        });
    });
</script>

@endsection
