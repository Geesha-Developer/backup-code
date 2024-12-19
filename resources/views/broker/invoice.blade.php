<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('fav.jpg') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    @foreach($load as $l)
    <title>Rate Coint Confirmation Load Number {{ $l->load_number }}</title>
    @endforeach
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        font-size: 12px;
    }


    table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border: 2px solid rgba(0, 0, 0, 0.05);
    }

    th,
    td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    footer {
        background-color: #f8f9fa;
        padding: 10px;
        text-align: center;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    footer span {
        margin-right: 10px;
    }

    @page {
        margin-top: 100px;
        /* Adjust as needed to make space for the header */
    }

    header {
        position: fixed;
        top: -11%;
        left: 0;
        right: 30%;
        height: 100px;
        /* Height of your header */
        /* background-color: #f8f9fa;  */
        padding: 10px;
        text-align: center;
    }

</style>

<body>
    <header>
        <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('https://dndlist.in/assets/img/cargo.png')); ?>"
            alt="Cargo Image" style="height:100px; width:auto; padding-left:45%">
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <!-- <img src="https://dndlist.in/assets/img/cargo.png" alt=""> -->


                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <span>{{ date('F j, Y H:i:s') }}</span>
                </div>


            </div>
            <div class="col-md-3">
                <div class="form-group">
                    @foreach($load as $l)
                    <span style="text-align:center">Rate Coint Confirmation Load Number {{ $l->load_number }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <span style="text-align:center;padding-left:40%;padding-bottom:80%;">RATE & LOAD CONFIRMATION</span>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Dispatcher</th>
                                    <th>Phone</th>
                                    <th>Fax</th>
                                    <th>Email</th>
                                    <th>W/O</th>
                                    <th>Load</th>
                                    <th>Shipers Date</th>
                                    <th>Todays's Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($load as $l)
                                <tr>
                                    <td>{{ $l->user->name }}</td>
                                    <td>{{ $l->load_telephone }}</td>
                                    <td>{{ $l->load_billing_fsc_rate }}</td>
                                    <td>{{ $l->user->email }}</td>
                                    <td>{{ $l->load_workorder }}</td>
                                    <td>{{ $l->load_number }}</td>
                                    <td>{{ date('m/d/Y', strtotime($l->load_shipper_date)) }}</td>
                                    <td><?php echo date('m/d/Y'); ?></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Carrier</th>
                                    <th>Phone</th>
                                    <th>Fax</th>
                                    <th>Equipment</th>
                                    <th>Agreed Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($load as $l)
                                <tr>
                                    <td>{{ $l->load_carrier }}</td>
                                    <td>{{ $l->load_telephone }}</td>
                                    <td>{{ $l->load_billing_fsc_rate }}</td>
                                    <td>{{ $l->load_equipment_type }}</td>
                                    <td>{{ $l->load_final_carrier_fee }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Shipper</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Weight</th>
                                <th>Notes</th>
                                <th>Description</th>
                                <th>Apointment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($load as $l)
                            <tr>
                                <td>{{ $l->load_shipperr }}</td>
                                <td>{{ $l->load_shipper_contact }}</td>
                                <td>{{ $l->load_shipper_date }}</td>
                                <td>{{ $l->load_type }}</td>
                                <td>{{ $l->load_shipper_qty }}</td>
                                <td>{{ $l->load_shipper_weight }}</td>
                                <td>{{ $l->load_shipper_shipping_notes }}</td>
                                <td>{{ $l->load_shipper_discription }}</td>
                                <td>{{ $l->load_shipper_appointment ? 'Yes' : 'No' }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Consignee</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Weight</th>
                                <th>Notes</th>
                                <th>Description</th>
                                <th>Apointment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($load as $l)
                            <tr>
                                <td>{{ $l->load_consignee }}</td>
                                <td>{{ $l->load_consigneer_contact }}</td>
                                <td>{{ $l->load_consignee_date }}</td>
                                <td>{{ $l->load_type }}</td>
                                <td>{{ $l->load_consignee_qty }}</td>
                                <td>{{ $l->load_consignee_weight }}</td>
                                <td>{{ $l->load_consigneer_notes }}</td>
                                <td>{{ $l->load_consignee_discription }}</td>
                                <td>{{ $l->load_consignee_appointment ? 'Yes' : 'No' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <span><b>Dispatch Notes</b></span><br><br>
                    <span>**Signee certifies that this contract can be honered without exceeding the driver's hour of
                        service Limitations.**</span><br><br>
                    <span><b>Most Important</b></span><br><br>
                    <ul class="list-group">
                        <ol class="list-group-item">1. Complaints about hours of service will not be considered valid
                            unless the carrier or driver calls our account payable at (551-
                            273-3628) at the time of the perceived coercion. Escalation Number 516-417-8386.</ol>
                        <ol class="list-group-item">2. Service failures resulting from failure to disclose hours of
                            service limitations will result in significant fines.</ol>
                        <ol class="list-group-item">3. Fines resulting from government enforcement of anti-coercion
                            rules will be paid by the carrier.</ol>



                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">

                </div>

                <div class="row">
                    <div class="col-md-9">
                        <ul class="list-group">
                            <ol class="list-group-item">4. Carrier must Call in for Check Calls Every day + loaded and
                                unloaded.</ol>
                            <ol class="list-group-item">5. All invoices must be emailed to ap@eternitylogistics.co along
                                with proof of delivery, bill of lading, and signed rate confirmation.</ol>
                            <ol class="list-group-item">6. Read the Standard Terms and Conditions below.</ol>

                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <span><b>Standard Terms and Conditions</b></span><br>
                        <ol>1. Carrier (Dispatcher/Driver) agrees to physically inspect and note all damages/all defects
                            at
                            pickup or delivery location on the bill of lading (BOL).</ol>
                        <ol>2. Carrier is responsible for all damages/defects to the load secured during transit.</ol>
                        <ol>3. Carrier must submit photographs of all damages noted on the BOL.</ol>
                        <ol>4. Carrier is responsible for any damage to the seal/packing over the load. The seal/packing
                            needs to be kept intact until the load is delivered.</ol>
                        <!-- <ol>&emsp;</ol> -->

                        <ol>5. Carrier is responsible for correct loading, counting of pallets, and must check weight on
                            each axle at the time of loading.</ol>
                        <ol>6. Carrier is responsible for hauling legal weight and load security. Carrier is responsible
                            to
                            make immediate protest, prior to transport, of any alleged weight overage or security
                            concerns,
                            else carrier will be accountable for the same.</ol>
                        <ol>7. All requests to reschedule an appointment must be made to the broker one day prior to
                            pick or
                            delivery.</ol>
                        <ol>8. Failure to reschedule and for any missed appointment to pick up or delivery may result in
                            a
                            fee of $150.00 Per Day or could result in cancellation of the listed pick up or delivery.
                        </ol>
                        <ol>9. Eternity Solutions does not pay detention/TONU on loads (unless specified).
                            Detention/TONU
                            will be paid only if the customer approves it.</ol>
                        <ol>10. Double brokered loads will not be paid.</ol>
                        <ol>11. Carrier to bill the Broker who is solely responsible for freight charges.</ol>
                        <ol>12. Carrier assumes responsibility for shipment requiring tarps whether noted on Rate
                            Confirmation.</ol>
                        <ol>13. Carrier is responsible for maintaining continuous/appropriate temperature in case of
                            Reefer
                            loads.</ol>
                        <ol>14. Carrier assumes full value responsibility for the shipment not to be limited by
                            insurance
                            capacity or previous agreement.</ol>
                        <ol>15. By transporting this shipment, the Carrier agrees to the above Terms and Conditions, and
                            this agreement shall be deemed to be in Full Force and Effective even if unsigned.</ol>
                        <ol>16. POD is to be shared within 48 hours of delivery, or it can lead to a $100 deduction.
                            </li>
                            </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <span><b>Please sign both pages of Confirmation & Terms and Conditions and
                                reply</b></span><br><br>
                        <span>**Signee certifies that this contract can be honored without exceeding driver's hour of
                            services limitions.**</span>
                    </div><br><br>
                    <div class="col-md-9">
                        <span><b>Carrier Pay:</b>Carrier Fee:${{ $l->load_final_carrier_fee }}, FSC Rate:$0 .,
                            <b>TOTAL:${{ $l->load_final_carrier_fee }} USD $</b></span><br><br>
                    </div><br><br>
                    <div class="col-md-9">
                        <span><b>Accepted
                                By:___________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:___________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature:___________________</b></span><br><br>
                        <span><b>Driver Name:_____________&nbsp;&nbsp;&nbsp;Cell#:_____________&nbsp;&nbsp;&nbsp;Truck
                                #:_____________&nbsp;&nbsp;&nbsp;Truck #:_____________</b></span>
                    </div>
                </div>

                <footer>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <p style="text-align: center;">Rate Confirmation Load Numbers:
                                    @foreach($load as $l)
                                    {{ $l->load_number }}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>

                <script>
                    // JavaScript to ensure load number appears on every page
                    window.onload = function () {
                        var loadNumber = "{{ $l->load_number }}"; // Retrieve load number from PHP
                        document.getElementById('load_number').innerText = "Load Number: " + loadNumber;
                    };

                </script>

</body>

</html>
