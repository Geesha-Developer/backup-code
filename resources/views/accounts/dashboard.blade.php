@extends('layouts.accounts.app')
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
    .db {
        display: grid;
        grid-gap: 1.5em;
        padding: 1.5em;
        width: 100%;
    }

    .db__bars {
        display: grid;
        grid-template-columns: 2.5em repeat(7, 1fr);
        grid-template-rows: repeat(5, 1fr) 2.5em;
        align-items: center;
        justify-items: center;
        position: relative;
    }

    .db__bars-cell {
        text-align: center;
        width: 100%;
    }

    .db__bars-cell-bar {
        background-image: linear-gradient(var(--primary), var(--secondary), var(--tertiary));
        border-radius: 0.25em;
        margin: auto;
        overflow: hidden;
        position: relative;
        height: 15em;
        width: 50%;
        max-width: 3em;
    }

    .db__bars-cell-bar-fill {
        background-color: var(--gray2);
        position: absolute;
        top: 0;
        right: -1px;
        left: -1px;
        height: 100%;
        transition:
            background-color var(--trans-dur),
            transform var(--trans-dur) ease-in-out;
    }

    .db__bars-cell:nth-child(1) {
        grid-column: 2;
    }

    .db__bars-cell:nth-child(2) {
        grid-column: 3;
    }

    .db__bars-cell:nth-child(3) {
        grid-column: 4;
    }

    .db__bars-cell:nth-child(4) {
        grid-column: 5;
    }

    .db__bars-cell:nth-child(5) {
        grid-column: 6;
    }

    .db__bars-cell:nth-child(6) {
        grid-column: 7;
    }

    .db__bars-cell:nth-child(7) {
        grid-column: 8;
    }

    .db__bars-cell:nth-child(-n + 7) {
        grid-row: 1 / 6;
    }

    .db__bars-cell:nth-child(n + 8):nth-child(-n + 13) {
        align-self: start;
        text-align: right;
    }

    .db__bars-cell:nth-child(n + 14) {
        align-self: end;
    }

    .db__bubble {
        background-color: var(--primary);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 50%;
        left: 50%;
        width: 12em;
        height: 12em;
        transform: translate(-50%, -50%) translate(-3em, -2em);
    }

    .db__bubble:nth-child(2) {
        background-color: var(--secondary);
        font-size: 0.9em;
        width: 9rem;
        height: 9rem;
        transform: translate(-50%, -50%) translate(5rem, -1rem);
    }

    .db__bubble:nth-child(3) {
        background-color: var(--tertiary);
        font-size: 0.8em;
        width: 7rem;
        height: 7rem;
        transform: translate(-50%, -50%) translate(1rem, 4.5rem);
    }

    .db__bubble-text {
        color: hsl(0, 0%, 100%);
        text-align: center;
    }

    .db__bubble-value {
        font-size: 2.25em;
    }

    .db__bubbles {
        position: relative;
        height: 17em;
    }

    .db__cell,
    .db__select {
        background-color: hsla(0, 0%, 100%, 0.5);
        backdrop-filter: blur(20px);
        box-shadow:
            0 0 0 1px hsla(0, 0%, 100%, 0.5) inset,
            0 0 0 2px hsla(0, 0%, 100%, 0) inset,
            0 0 0.75em hsl(0, 0%, 0%, 0.3);
        -webkit-backdrop-filter: blur(20px);
    }

    .db__cell {
        border-radius: 0.5em;
        padding: 1.5em 1.25em;
        display: flex;
        flex-direction: column;
        transition:
            background-color var(--trans-dur),
            box-shadow var(--trans-dur);
    }

    .db__counter {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-grow: 1;
    }

    .db__counter-value,
    .db__heading,
    .db__subheading {
        font-weight: 500;
    }

    .db__counter-label {
        line-height: 1;
        margin-left: 0.75em;
        text-align: right;
    }

    .db__counter-value {
        font-size: 2em;
        line-height: 1;
    }

    .db__heading {
        font-size: 2em;
    }

    .db__order {
        display: flex;
        padding: 1em 0;
    }

    .db__order:not(:last-child) {
        box-shadow: 0 1px 0 hsla(0, 0%, 50%, 0.3);
    }

    .db__order-cat,
    .db__order-name {
        margin-right: 1em;
    }

    .db__order-cat {
        background-color: hsla(var(--hue), 90%, 55%, 0.2);
        border-radius: 50%;
        display: grid;
        place-items: center;
        align-self: center;
        width: 2.75em;
        height: 2.75em;
        transition: background-color var(--trans-dur);
    }

    .db__order-cat-icon {
        color: var(--primary);
        width: 1.5em;
        height: 1.5em;
        transition: color var(--trans-dur);
    }

    .db__order-name {
        flex-grow: 1;
    }

    .db__product {
        display: flex;
        justify-content: space-between;
    }

    .db__product-details {
        width: 33%;
    }

    .db__product-details+.db__product-details {
        text-align: right;
        width: 67%;
    }

    .db__product-detail-line {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .db__product-table {
        border-collapse: collapse;
        text-align: left;
        width: 100%;
    }

    .db__product-table th,
    .db__product-table td {
        padding: 1em 0.5em 1em 0;
    }

    .db__product-table th {
        font-weight: 400;
    }

    .db__product-table th:nth-child(odd) {
        width: 30%;
    }

    .db__product-table th:nth-child(even) {
        width: 20%;
    }

    .db__product-table td {
        max-width: 1px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .db__product-table th,
    .db__product-table tr:not(:last-child) td {
        box-shadow: 0 -1px 0 hsla(0, 0%, 50%, 0.3) inset;
    }

    .db__product-table thead,
    .db__product-table td+td {
        display: none;
    }

    .db__progress {
        background-image: linear-gradient(90deg, var(--primary), var(--secondary), var(--tertiary));
        height: 0.25em;
        margin-bottom: 1.25em;
        overflow: hidden;
        position: relative;
    }

    .db__progress-fill {
        background-color: var(--gray2);
        position: absolute;
        top: -1px;
        right: 0;
        bottom: -1px;
        left: 0;
        transition:
            background-color var(--trans-dur),
            transform var(--trans-dur) ease-in-out;
    }

    .db__select {
        border-radius: 0.2em;
        display: inline-flex;
        align-items: center;
        margin-right: 1em;
        padding: 0.75em 1.5em;
        transition:
            background-color var(--trans-dur),
            box-shadow var(--trans-dur),
            color var(--trans-dur);
    }

    .db__select:focus {
        outline: transparent;
    }

    .db__select:focus,
    .db__select:hover {
        background-color: hsla(0, 0%, 100%, 0.7);
    }

    .db__select:last-child {
        margin-right: 0;
    }

    .db__select::after {
        box-shadow: -0.125em -0.125em 0 0 currentColor inset;
        content: "";
        display: inline-block;
        margin-left: 1.25em;
        width: 0.5em;
        height: 0.5em;
        transform: translateY(-0.125em) rotate(45deg);
    }

    .db__select-icon {
        margin-right: 0.75em;
        width: 1.5em;
        height: 1.5em;
    }

    .db__status {
        transition: color var(--trans-dur);
    }

    .db__status::before {
        background-color: currentColor;
        border-radius: 50%;
        content: "";
        display: inline-block;
        margin-right: 0.5em;
        width: 0.5em;
        height: 0.5em;
        vertical-align: 0.1em;
    }

    .db__status--green {
        color: hsl(123, 90%, 25%);
    }

    .db__status--orange {
        color: hsl(33, 90%, 35%);
    }

    .db__status--red {
        color: hsl(3, 90%, 35%);
    }

    .db__subheading {
        font-size: 1.5em;
        line-height: 1;
        margin-bottom: 1.5rem;
    }

    .db__toolbar {
        color: var(--gray1);
        min-height: 3em;
    }

    .db__toolbar-btns {
        margin-top: 1em;
    }

    .db__top-stat {
        font-size: 1em;
        font-weight: normal;
        margin-bottom: 1em;
    }

    small,
    time,
    .db__bars-cell,
    .db__product-table th,
    .db__top-stat {
        color: var(--gray7);
        transition:
            background-color var(--trans-dur),
            color var(--trans-dur);
    }

    /* `:focus-visible` support */
    @supports selector(:focus-visible) {
        .db__select:focus {
            background-color: hsla(0, 0%, 100%, 0.5);
        }

        .db__select:focus-visible,
        .db__select:hover {
            background-color: hsla(0, 0%, 100%, 0.7);
        }
    }

    /* Dark theme */
    @media (prefers-color-scheme: dark) {

        body,
        button {
            color: var(--gray1);
        }

        .db__bars-cell-bar-fill,
        .db__progress-fill {
            background-color: var(--gray9);
        }

        .db__order-cat {
            background-color: hsla(var(--hue), 90%, 65%, 0.2);
        }

        .db__order-cat-icon {
            color: hsl(var(--hue), 90%, 65%);
        }

        .db__cell,
        .db__select {
            background-color: hsla(var(--hue), 10%, 10%, 0.7);
            box-shadow:
                0 0 0 1px hsla(var(--hue), 10%, 10%, 0.7) inset,
                0 0 0 2px hsla(0, 0%, 100%, 0.2) inset,
                0 0 0.75em hsl(var(--hue), 10%, 10%, 0.3);
        }

        .db__select:focus,
        .db__select:hover {
            background-color: hsla(var(--hue), 10%, 25%, 0.7);
        }

        .db__status--green {
            color: hsl(123, 90%, 40%);
        }

        .db__status--orange {
            color: hsl(33, 90%, 70%);
        }

        .db__status--red {
            color: hsl(3, 90%, 70%);
        }

        small,
        time,
        .db__bars-cell,
        .db__product-table th,
        .db__top-stat {
            color: var(--gray3);
        }

        /* `:focus-visible` support */
        @supports selector(:focus-visible) {
            .db__select:focus {
                background-color: hsla(var(--hue), 10%, 10%, 0.7);
            }

            .db__select:focus-visible,
            .db__select:hover {
                background-color: hsla(var(--hue), 10%, 25%, 0.7);
            }
        }
    }

    /* Tablet */
    @media (min-width: 768px) {
        .db {
            grid-template-columns: 1fr 1fr 2fr;
            grid-template-areas:
                "a a g"
                "b b g"
                "c d g"
                "e e h"
                "e e h"
                "f f h";
        }

        .db__bubble {
            width: 16em;
            height: 16em;
            transform: translate(-50%, -50%) translate(-4em, -2em);
        }

        .db__bubble:nth-child(2) {
            width: 12rem;
            height: 12rem;
            transform: translate(-50%, -50%) translate(6rem, -1rem);
        }

        .db__bubble:nth-child(3) {
            width: 8rem;
            height: 8rem;
            transform: translate(-50%, -50%) translate(1rem, 6rem);
        }

        .db__bubbles {
            height: 20em;
        }

        .db__cell:nth-child(2) {
            grid-area: b;
        }

        .db__cell:nth-child(3) {
            grid-area: c;
        }

        .db__cell:nth-child(4) {
            grid-area: d;
        }

        .db__cell:nth-child(5) {
            grid-area: e;
        }

        .db__cell:nth-child(6) {
            grid-area: f;
        }

        .db__cell:nth-child(7) {
            grid-area: g;
        }

        .db__cell:nth-child(8) {
            grid-area: h;
        }

        .db__product-table thead {
            display: table-header-group;
        }

        .db__product-table td {
            display: none;
        }

        .db__product-table td+td {
            display: table-cell;
        }

        .db__toolbar {
            grid-area: a;
        }
    }

    /* Desktop */
    @media (min-width: 1024px) {
        .db__toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .db__toolbar-btns {
            margin-top: 0;
        }
    }

    @media (min-width: 1280px) {
        .db {
            grid-template-columns: 1fr 1fr 1fr 2fr;
            grid-template-areas:
                "a a a g"
                "b c d g"
                "e e e g"
                "e e e h"
                "f f f h"
                "f f f h";
        }
    }

    .db__cell {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 10px;
        background: #f1f3f4;
        padding: 14px 14px;
    }

    .box1 {
        background-image: linear-gradient(to right, #f7769d, #fda682);
        color: #fff;
    }

    .box2 {
        background-image: linear-gradient(to right, #7ccdff, #7095ff);
        color: #fff;
    }

    .box3 {
        background-image: linear-gradient(to right, #c07dfe, #f19ff6);
        color: #fff;
    }

    .db__bars {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .db__bars-cell {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin: 5px 0;
    }

    .db__bars-cell-bar {
        position: relative;
        width: 100%;
        height: 20px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
    }

    .db__bars-cell-bar-fill {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #007bff;
    }

    .db__bars-cell-bar-fill::after {
        content: attr(title);
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 3px 6px;
        border-radius: 3px;
        font-size: 12px;
    }

    .db__bars-cell>time {
        margin-left: 10px;
        font-size: 12px;
        color: #666;
    }
</style>
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
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <div class="db__cell box3 mt-3">
                            <h2 class="db__top-stat">Total Margin</h2>
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
                    <div class="col-md-3">
                        <div class="db__cell box2 mt-3">
                            <h2 class="db__top-stat">Yesterday Loads</h2>
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
                    <div class="col-md-3">
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
                    <div class="accordion" id="accordionExample">
                        @foreach($topMaximumLoadCustomers as $key => $loadCount)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $key }}">
                                    <button class="accordion-button {{ $key === 0 ? '' : 'collapsed' }}" 
                                            type="button" style="font-weight: 600;"
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $key }}" 
                                            aria-expanded="{{ $key === 0 ? 'true' : 'false' }}" 
                                            aria-controls="collapse{{ $key }}">
                                        {{ $loadCount->load_bill_to }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $key }}" 
                                    class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}" 
                                    aria-labelledby="heading{{ $key }}" 
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between mb-3">
                                            <span>Total Loads</span>
                                            <span style="cursor: pointer; color: #007bff; font-weight: 600;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#dashboard-load-modal"
                                                data-customer="{{ $loadCount->load_bill_to }}">
                                                {{ $loadCount->load_count }}
                                            </span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
<div class="modal" id="dashboard-load-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-top: 0;font-size: 18px;font-weight: 700;" id="dashboardLoadModalLabel">Load Details</h5>
                <input type="text" id="custom-search" class="form-control" placeholder="Search Load #..." style="width: 24%; margin-right: 21px;">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                   <div class="table-responsive">
                        <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>Load No</th>
                                        <th>Agent</th>
                                        <th>Customer Final Rate</th>
                                        <th>Carrier Final Rate</th>
                                        <th>Margin</th>
                                        <th>Margin %</th>
                                    </tr>
                                </thead>
                                <tbody id="load-details">
                                    <!-- Content will be dynamically injected -->
                                </tbody>
                            </table>
                   </div>
            </div>
        </div>
    </div>
</div>

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
    // Wait for the document to be fully loaded
    document.addEventListener("DOMContentLoaded", function () {
        // Get all anchor tags in the document
        var anchorTags = document.querySelectorAll("a");

        // Loop through each anchor tag
        anchorTags.forEach(function 2693_anchor {
            // Set text decoration to unset
            anchor.style.textDecoration = "unset";
        });
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


<script>
    var datepickerButton = document.getElementById('datepicker-button');
    var selectedDateInput = document.getElementById('selected-date');

    datepickerButton.addEventListener('click', function () {
        var today = new Date();
        var year = today.getFullYear();
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var day = String(today.getDate()).padStart(2, '0');
        var currentDate = year + '-' + month + '-' + day;
        selectedDateInput.value = currentDate;
        var event = new Event('change');
        selectedDateInput.dispatchEvent(event);
    });
</script>

<script>
    function getDate() {
        var selectedDate = document.getElementById("dashboard_name").value;
        console.log("Selected date:", selectedDate);
        // Add your logic to handle the selected date here
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const salesData = @json($salesData);

        // Extract labels and sales values
        const labels = salesData.map(data => new Date(data.date).toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' }));
        const salesValues = salesData.map(data => data.total_shipper_rate - data.total_carrier_fee);

        // Chart configuration
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Sales',
                    data: salesValues,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true,
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'category',
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Net Sales (USD)'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `$${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('dashboard-load-modal');
    const loadDetails = document.getElementById('load-details');
    const searchInput = document.getElementById('custom-search');

    // Function to filter the table rows based on search input
    searchInput.addEventListener('input', function () {
        const query = searchInput.value.toLowerCase();
        const rows = loadDetails.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const cells = row.getElementsByTagName('td');
            let rowMatches = false;

            // Check if any cell in the row contains the search query
            Array.from(cells).forEach(cell => {
                if (cell.textContent.toLowerCase().includes(query)) {
                    rowMatches = true;
                }
            });

            // Show or hide the row based on whether it matches the search query
            row.style.display = rowMatches ? '' : 'none';
        });
    });

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const customer = button.getAttribute('data-customer');

        // Clear existing content
        loadDetails.innerHTML = '';

        // Fetch loads for the selected customer
        fetch(`/get-loads/${encodeURIComponent(customer)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.loads && data.loads.length) {
                    data.loads.forEach(load => {
                        const row = `<tr>
                            <td>${load.load_number}</td>
                            <td>${load.agent_name}</td>
                            <td>${load.shipper_load_final_rate}</td>
                            <td>${load.load_final_carrier_fee}</td>
                            <td>${load.margin.toFixed(2)}</td>
                            <td>${load.margin_percentage.toFixed(2)}%</td>
                        </tr>`;
                        loadDetails.innerHTML += row;
                    });
                } else {
                    loadDetails.innerHTML = `<tr><td colspan="6" class="text-center">No loads available</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error fetching load details:', error);
                loadDetails.innerHTML = `<tr><td colspan="6" class="text-center">Error fetching data</td></tr>`;
            });
    });
});

</script>
@endsection