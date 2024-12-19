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
        <div class="block-header" style="padding: 16px 15px !important">
                    <h2><b>Load Data</b> </h2>
        </div>

        <div class="container-fluid p-0">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                          
                            <div class="table-responsive">
                                <table class="table table-bordered table-responsive dataTable no-footer">
                                    <thead>
                                    <tr>
                                            <th style="color: #fff !important;">Load Number</th>
                                            <th style="color: #fff !important;">Broker Name</th>
                                            <th style="color: #fff !important;">Load Bill TO</th>
                                            <th style="color: #fff !important;">Load Load Status</th>
                                            <th style="color: #fff !important;">Load Payment Type</th>
                                            <th style="color: #fff !important;">Load Shipper Rate</th>
                                            <th style="color: #fff !important;">Load Other Change</th>
                                            <th style="color: #fff !important;">Load Final Rate</th>
                                            <th style="color: #fff !important;">Load Billing Type</th>
                                            <th style="color: #fff !important;">Load Advance Payment</th>
                                            <th style="color: #fff !important;">Load Equipment Type</th>
                                            <th style="color: #fff !important;">Load Carrier Fee</th>
                                            <th style="color: #fff !important;">load Billing FSC Rate</th>
                                            <th style="color: #fff !important;">Load Other Charge</th>
                                            <th style="color: #fff !important;">Shipper Load Other Charge </th>
                                            <th style="color: #fff !important;">RC</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($loads as $load)
                                        <tr>
                                            <td class="dynamic-data">{{ $load->load_number }}</td>
                                            <td class="dynamic-data">{{ $load->user->name }}</td>
                                            <td class="dynamic-data">{{ $load->load_bill_to }}</td>
                                            <td class="dynamic-data">{{ $load->load_status }}</td>
                                            <td class="dynamic-data">{{ $load->load_payment_type }}</td>
                                            <td class="dynamic-data">{{ $load->load_shipper_rate }}</td>
                                            <td class="dynamic-data">{{ $load->load_other_change }}</td>
                                            <td class="dynamic-data">{{ $load->load_final_rate }}</td>
                                            <td class="dynamic-data">{{ $load->load_advance_payment }}</td>
                                            <td class="dynamic-data">{{ $load->load_billing_type }}</td>
                                            <td class="dynamic-data">{{ $load->load_mc_no }}</td>
                                            <td class="dynamic-data">{{ $load->load_equipment_type }}</td>
                                            <td class="dynamic-data">{{ $load->load_carrier_fee }}</td>
                                            <td class="dynamic-data">{{ $load->load_billing_fsc_rate }}</td>
                                            <td class="dynamic-data">{{ $load->load_other_charge }}</td>
                                            <td class="dynamic-data">
                                            <a href="{{ route('download.pdf', ['id' => $load->id]) }}"
                                                    target="_blank"><i class="fas fa-file-pdf text-danger"
                                                        aria-hidden="true" style="font-size: 24px;"></i>
                                            </a>
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
@endsection