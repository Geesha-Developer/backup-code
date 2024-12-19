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
<style>
    button.close {
        position: absolute;
        right: 14px;
        color: #000;
        top: 11px !important;
        font-size: 32px;
    }

    button#hideFormButton {
        float: right;
    }

    input#customer_telephone::placeholder {
        font-size: 8px;
    }

    button.btn.dropdown-toggle {
        background: unset;
        border: 1px solid #b2aeae;
        color: #000;
        width: 100%;
        text-align: left;
        padding: 4px 7px;
    }
    button.btn.file {
    background-color: #888;
    color: #fff;
    width: unset;
    padding: 6px 11px;
}
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
           <h2>Viewer </h2>
        </div>
        <div class="container-fluid p-0">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 p-0">
                    <div class="card">
                        <div class="body">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal"> ADD Viewer</button>
                            <button type="button" class="btn btn-success" id="hideFormButton"><i
                                    class="fa fa-eye"></i></button>

                            <table id="dataTableDelivered"
                                class="table table-bordered table-responsive dataTable no-footer" style="">
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form class="hide">
                                                <div class="card-header" style="color: #fff;">
                                                    <h3 class="card-title head">CUSTOMER DETAILS</h3>
                                                    <button type="button" class="close" style="top: -5px;"
                                                        data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>

                                                <div class="card-body text-left">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Customer Name <code>*</code></label>
                                                                <input class="form-control select2" type="text" required
                                                                    name="customer_name" id="customer_name"
                                                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <input type="text" name="user_id" hidden>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="mr-2">MC# /FF#
                                                                    <code id="mc_ff_code"
                                                                        style="display: none;">*</code>
                                                                </label>
                                                                <div class="d-flex" style="width: 100%;">
                                                                    <select
                                                                        style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 9px; line-height: 0.2em; color: #666; width: 45% !important; height:30px !important"
                                                                        class="form-control select2 mr-2"
                                                                        name="customer_mc_ff" id="customer_mc_ff">
                                                                        <option selected="selected"
                                                                            style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;"
                                                                            id="mc_ff_code_na">NA</option>
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;">
                                                                            MC</option>
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 15px; line-height: 0.2em; color: #666;">
                                                                            FF</option>
                                                                    </select>
                                                                    <input class="form-control select2"
                                                                        name="customer_mc_ff_input"
                                                                        id="customer_mc_ff_input"
                                                                        style="width: 100%; height:30px !important; display: none;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Address <code>*</code></label>
                                                                <input type="text" class="form-control select2" required
                                                                    name="customer_address" id="customer_address"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px;  ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Country <code>*</code></label>
                                                                <div>
                                                                    <select
                                                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                                                                        class="form-control select2" required
                                                                        name="customer_country" id="country">
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                            selected="selected" class="hiddenOption">
                                                                            Choose Country
                                                                        </option>
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;">
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>State <code>*</code></label>
                                                                <div>
                                                                    <select
                                                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;"
                                                                        class="form-control select2" required
                                                                        name="customer_state" id="state">

                                                                        <option value="Please Select" selected>Please
                                                                            Select</option>
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;">
                                                                        </option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>City <code>*</code></label>
                                                                <input type="text" class="form-control select2" required
                                                                    name="customer_city" id="customer_city"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Zip <code>*</code></label>
                                                                <input type="number" class="form-control select2"
                                                                    required name="customer_zip" id="customer_zip"
                                                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group d-flex align-items-center">
                                                                <label class="one-line-label"
                                                                    style="white-space: nowrap;margin-right: 34px;margin-bottom: 5px;">Same
                                                                    as Physical
                                                                    Address</label>
                                                                <input class="form-control select2" type="checkbox"
                                                                    name="same_as_physical" id="same_as_physical"
                                                                    style="width: 15px;height: 30px;margin-top: 12px;margin-bottom: 17px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Billing Address <code>*</code></label>
                                                                <input type="text" class="form-control select2" required
                                                                    type="text" name="customer_billing_address"
                                                                    id="customer_billing_address"
                                                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Billing City <code>*</code></label>
                                                                <input type="text" class="form-control select2" required
                                                                    name="customer_billing_city"
                                                                    id="customer_billing_city"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Billing State <code>*</code></label>
                                                                <input type="text" class="form-control select2" required
                                                                    name="customer_billing_state"
                                                                    id="customer_billing_state"
                                                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Billing Zip <code>*</code></label>
                                                                <input type="number" class="form-control select2"
                                                                    required name="customer_billing_zip"
                                                                    id="customer_billing_zip"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Billing Country <code>*</code></label>
                                                                <input type="text" class="form-control select2" required
                                                                    type="text" name="customer_billing_country"
                                                                    id="customer_billing_country"
                                                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>POC Name</label>
                                                                <input type="text" class="form-control select2"
                                                                    name="customer_primary_contact"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Telephone <code>*</code></label>
                                                                <input type="number" maxlimit="12"
                                                                    class="form-control select2" required
                                                                    name="customer_telephone" id="customer_telephone"
                                                                    placeholder="Special Character Are Not Allowed"
                                                                    style="width: 100%; height: 30px; padding: 0px 0 0 10px;" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Extn. </label>
                                                                <input type="text" class="form-control select2"
                                                                    name="customer_extn"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Email <code>*</code></label>
                                                                <input type="email" class="form-control select2"
                                                                    required name="customer_email"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label>Website URL </label>
                                                                <input class="form-control select2"
                                                                    name="adv_customer_webiste_url"
                                                                    id="adv_customer_webiste_url"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Fax</label>
                                                                <input type="text" class="form-control select2"
                                                                    name="customer_fax"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Acc Pay Email</label>
                                                                <input type="email" class="form-control select2"
                                                                    name="customer_secondary_email"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>AP Contact</label>
                                                                <input type="number" class="form-control select2"
                                                                    name="customer_billing_telephone"
                                                                    style="width: 100%;height:30px;padding: 0px 0 0 10px; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>AP Extn.</label>
                                                                <input type="text" class="form-control select2"
                                                                    name="customer_billing_extn"
                                                                    style="width: 100%;height:30px ;padding: 0px 0 0 10px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group align-items-center">
                                                                <label class="mr-2">Status <code>*</code></label>
                                                                <div>
                                                                    <select
                                                                        style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px; "
                                                                        class="form-control select2" required
                                                                        name="customer_status">
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;"
                                                                            selected="selected" class="hiddenOption">
                                                                            Please Select
                                                                        </option>
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;">
                                                                            Active</option>
                                                                        <option
                                                                            style="font-family: 'Poppins', sans-serif;font-weight: 400;font-size: 15px;line-height: 0.2em;color: #666;">
                                                                            In-Active</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-info" value="Add">
                                                        <input type="button" class="btn btn-danger" data-dismiss="modal"
                                                            value="Cancel">
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <thead>
                                    <tr>
                                        <th>BOL #</th>
                                        <th>3rd Party</th>
                                        <th>Carrier</th>
                                        <th>Freight Charges</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Emeergency #</th>
                                        <th>C.O.D</th>
                                        <th>Value</th>
                                        <th>Notes</th>
                                        <th>Items</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="dynamic-data">1.</td>
                                        <td class="dynamic-data">
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Select...
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Link 1</a>
                                                    <a class="dropdown-item" href="#">Link 2</a>
                                                    <a class="dropdown-item" href="#">Link 3</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="dynamic-data">
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Select...
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Link 1</a>
                                                    <a class="dropdown-item" href="#">Link 2</a>
                                                    <a class="dropdown-item" href="#">Link 3</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="dynamic-data">
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Select...
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Link 1</a>
                                                    <a class="dropdown-item" href="#">Link 2</a>
                                                    <a class="dropdown-item" href="#">Link 3</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="dynamic-data">
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Select...
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Link 1</a>
                                                    <a class="dropdown-item" href="#">Link 2</a>
                                                    <a class="dropdown-item" href="#">Link 3</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="dynamic-data">
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Select...
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Link 1</a>
                                                    <a class="dropdown-item" href="#">Link 2</a>
                                                    <a class="dropdown-item" href="#">Link 3</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="dynamic-data">Lorem ipsum</td>
                                        <td class="dynamic-data">
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Select...
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Link 1</a>
                                                    <a class="dropdown-item" href="#">Link 2</a>
                                                    <a class="dropdown-item" href="#">Link 3</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="dynamic-data">0.00</td>
                                        <td class="dynamic-data">
                                            <textarea disabled name="comment_text" rows="1">No Comment Found</textarea>
                                        </td>
                                        <td class="dynamic-data">
                                            <button type="button" class="btn">ITEMS</button>
                                        </td>
                                        <td class="dynamic-data">
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle file"
                                                    data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu" style="right: 0px;">
                                                    <li>
                                                        <a href="#" target="_blank">
                                                            <i class="fas fa-file-pdf text-danger dynamic-data"
                                                                style="margin:0 10px; font-size: 24px;"></i> RC PDF
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="fa fa-upload dynamic-data" aria-hidden="true" style="margin:0 10px; color: #0160c8; font-size: 20px;"></i>Upload</a>
                                                    </li>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection