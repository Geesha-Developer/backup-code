@extends('layouts.broker.app')

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
            <h2>Load List</h2>
        </div>

        <div class="container-fluid">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="carriers-tab" data-bs-toggle="tab" href="#carriers" role="tab"
                        aria-controls="carriers" aria-selected="true"
                        style="font-size: 15px;color: #000;font-weight:500">Open</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="customers-tab" data-bs-toggle="tab" href="#customers" role="tab"
                        aria-controls="customers" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Delivered</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="carriers" role="tabpanel" aria-labelledby="carriers-tab">
                    <table id="dataTableOpen" class="table table-bordered display">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Load#</th>
                                <th>W/O#</th>
                                <th>Customer#</th>
                                <th>Load Create Date</th>
                                <th>Shipper Date</th>
                                <th>Del Date</th>
                                <th>Carrier</th>
                                <th>Pickup Location</th>
                                <th>Unloading Location</th>
                                <th>Final Del</th>
                                <th>Load Status</th>
                                <th>Ageing</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @foreach($brokerLoadStatus as $loads)
                            @if($loads->load_status == 'Open')
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $loads->load_number }}</td>
                                <td>{{ $loads->load_workorder }}</td>
                                <td>{{ $loads->load_bill_to }}</td>
                                <td>{{ $loads->created_at }}</td>
                                <td>{{ $loads->load_shipper_appointment }}</td>
                                <td>{{ $loads->load_consignee_appointment }}</td>
                                <td>{{ $loads->load_carrier }}</td>
                                <td>{{ $loads->load_shipper_location }}</td>
                                <td>{{ $loads->load_consignee }}</td>
                                <td>{{ $loads->load_consignee_1 }}</td>
                                <td>{{ $loads->load_status }}</td>
                                <td>Need to be Discuss</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                    <table id="dataTableDelivered" class="table table-bordered display">
                    <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Load #</th>
                                <th>W/O #</th>
                                <th>Carrier</th>
                                <th>Shipper Date</th>
                                <th>Load Create Date</th>
                                <th>Del Date</th>
                                <th>Customer #</th>
                                <th>Pickup Location</th>
                                <th>Unloading Location</th>
                                <th>Final Del</th>
                                <th>Load Status</th>
                                <th>Ageing</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @foreach($brokerLoadStatus as $loads)
                            @if($loads->load_status == 'Deliverd')
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $loads->load_number }}</td>
                                <td>{{ $loads->load_workorder }}</td>
                                <td>{{ $loads->load_carrier }}</td>
                                <td>{{ $loads->load_shipper_appointment }}</td>
                                <td>{{ $loads->created_at }}</td>
                                <td>{{ $loads->load_consignee_appointment }}</td>
                                <td>{{ $loads->load_bill_to }}</td>
                                <td>{{ $loads->load_shipper_location }}</td>
                                <td>{{ $loads->load_consignee }}</td>
                                <td>{{ $loads->load_consignee_1 }}</td>
                                <td>{{ $loads->load_status }}</td>
                                <td>Need to be Discuss</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JavaScript library -->
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



@endsection
