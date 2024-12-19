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
    <div class="block-header" style="padding: 16px 15px !important;">
            <h2><b>Dashboard</b></h2>
    </div>
    <div class="main">
        <div class="row">
            <div class="col-md-8 dynamic-data">
                <div class="db__cell">
                    <div class="d-flex justify-content-between">
                        <h1 class="db__heading">Overview</h1>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="db__cell box1 mt-3">
                                <h2 class="db__top-stat">Total Revenue</h2>
                                <div class="db__progress">
                                    <div class="db__progress-fill" style="transform:translateX(15%)">
                                    </div>
                                </div>
                                <div class="db__counter">
                                    <div class="db__counter-value" title="$3,330,050.90">${{ $revenue }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="db__cell box2 mt-3">
                                <h2 class="db__top-stat">Total Carrier</h2>
                                <div class="db__progress">
                                    <div class="db__progress-fill" style="transform:translateX(20%)">
                                    </div>
                                </div>

                                <div class="db__counter">
                                    <div class="db__counter-value">
                                        <span>{{ $carrierCountDashboard }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="db__cell box3 mt-3">
                                <h2 class="db__top-stat">Total Margin <span style="font-size:10px">(Customer Amt - Carrier Amt)</span></h2>
                                <div class="db__progress">
                                    <div class="db__progress-fill" style="transform:translateX(42%)">
                                    </div>
                                </div>
                                <div class="db__counter">
                                    <div class="db__counter-value">
                                        <span>${{ $finalTotal }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">

                        <div class="col-md-4">
                            <div class="db__cell box2 mt-3">
                                <h2 class="db__top-stat">Total Load in 24 Hours</h2>
                                <div class="db__progress">
                                    <div class="db__progress-fill" style="transform:translateX(20%)">
                                    </div>
                                </div>

                                <div class="db__counter">
                                    <div class="db__counter-value">
                                        <span>{{ $loadCount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="db__cell box3 mt-3">
                                <h2 class="db__top-stat">Total Customer Added</h2>
                                <div class="db__progress">
                                    <div class="db__progress-fill" style="transform:translateX(42%)">
                                    </div>
                                </div>
                                <div class="db__counter">
                                    <div class="db__counter-value">
                                        <span>{{ $newCoustmerAdded }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="db__cell mt-3">
                    <h2 class="db__subheading">Sales</h2>
                    <canvas id="salesChart"></canvas>
                </div>

                
            </div>
            <div class="col-md-4 dynamic-data">
                <div class="col-md-12">
                    <div class="db__cell">
                        <h2 class="db__subheading">Number of Shippers and Carriers</h2>
                        <div class="db__bubbles" style="height: 17.7em;">
                            <div class="db__bubble">
                                <span class="db__bubble-text">Loads<br><strong
                                        class="db__bubble-value">{{ $count }}</strong><br>Total Loads</span>
                            </div>
                            <div class="db__bubble">
                                <span class="db__bubble-text">Agents<br><strong
                                        class="db__bubble-value">{{ $agents }}</strong><br>Total Agents</span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="db__cell mt-3">
                        <h2 class="db__subheading">Maximum Loads With Customers</h2>
                        @foreach($topMaximumLoadCustomers as $loadCount)
                        <div class="db__order">
                            <div class="db__order-cat">
                                <img src="{{ asset('assets/images/dashboard_customer.png') }}" alt=""
                                    style="width: 32px;height: 32px;">
                            </div>
                            <div class="db__order-name">
                                {{ $loadCount-> load_bill_to}}<br>
                            </div>
                            <div><strong>{{ $loadCount->load_count }} Loads</strong></div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <!-- <div class="col-md-12 dynamic-data">
                <div class="db__cell mt-3">
                    <h2 class="db__subheading">Best Performance Broker</h2>
                    <div class="table-responsive">
                        <table
                            class="table table-bordered dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Broker</th>
                                    <th style="color: #fff !important;">No of Load</th>
                                    <th style="color: #fff !important;">Margin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bestPerformance as $index => $bpc)
                                <tr>
                                    <td style="padding: 7px 10px !important; vertical-align: middle !important;">
                                        {{ $bpc->name }}</td>
                                    <td style="padding: 7px 10px !important; vertical-align: middle !important;">
                                        {{ $bpc->load_number }}</td>
                                    <td style="padding: 7px 10px !important; vertical-align: middle !important;">
                                        {{ $bpc->load_final_carrier_fee }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('user_chart').getContext('2d');
    var userChart = new Chart(ctx, {
        type: 'bar',

        data: {
            labels: {
                !!json_encode($labels) !!
            },
            datasets: {
                !!json_encode($datasets) !!
            },
        },
    });
</script>
<script>
    var ctx = document.getElementById('load_chart').getContext('2d');
    var userChart = new Chart(ctx, {
        type: 'bar',

        data: {
            labels: {
                !!json_encode($labels2) !!
            },
            datasets: {
                !!json_encode($datasets2) !!
            },
        },
    });
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js">
</script>

<script>
    $(document).ready(function () {
        // Initialize Bootstrap tabs
        var tabTriggerEl = document.getElementById('myTab');
        var tab = new bootstrap.Tab(tabTriggerEl);
        tab.show();
    });
</script>

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