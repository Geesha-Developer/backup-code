@extends('adminlte::page')

@section('content_header')
<!-- <h1>Carrier Page</h1> -->
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mdbootstrap/css/mdb.min.css"
    integrity="sha384-<new-generated-integrity-value>" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css"
    integrity="sha384-<new-generated-integrity-value>" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before {
        bottom: .5em;
    }

    .btn {

        padding: 0.375rem 0.75rem;
    }

    .expanded-row {
        background-color: #f2f2f2;
    }

    button.toggle-button {
        border: unset;
        background: transparent;
    }

</style>
@stop

@section('content')
<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">Sr No.</th>
            <th class="th-sm">Name</th>
            <th class="th-sm">Address</th>
            <th class="th-sm">Contact</th>
            <th class="th-sm">Status</th>
            <th class="th-sm">Date Added</th>
            <th class="th-sm">Added By User</th>
            <th class="th-sm">Team Lead</th>
            <th class="th-sm">Team Manager</th>
            <th class="th-sm" style="text-align:center">Action</th>

        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach($consignees as $consignee)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$consignee->consignee_name}}</td>
            <td>{{$consignee->consignee_address}} {{$consignee->consignee_country}} {{$consignee->consignee_state}}
                {{$consignee->consignee_city}} {{$consignee->consignee_zip}}</td>
            <td>{{$consignee->consignee_contact_name}}</td>
            <td>{{$consignee->consignee_status}}</td>
            <td>{{$consignee->created_at}}</td>
            <td>{{$consignee->added_by_user}}</td>
            <td>NA</td>
            <td>Adam</td>
            <td style="text-align:center">
                <form id="deleteForm{{$consignee->id}}" action="{{ route('consignees.destroy', $consignee->id) }}"
                    method="post">
                    @csrf
                    @method('DELETE')
                    <a href="#" onclick="deleteConsignee({{$consignee->id}})">
                        <i class="fa fa-trash" style="color:red"></i>
                    </a>
                </form>
                <a href="{{ route('consignees.edit', $consignee->id) }}"><i class="fa-solid fa-pen"
                        style="color:#007bff"></i></a>
                <button class="toggle-button"><i class="fa-solid fa-plus"
                        style="color:#007bff;text-align:center"></i></button>
                        <br>&nbsp;
                <table class="table table-striped additional-data" style="display: none;">
                    <thead>
                        <tr>
                            <th class="th-sm">Consignee Address 2</th>
                            <th class="th-sm">Consignee Address 3</th>
                            <th class="th-sm">Consignee Fax</th>
                            <th class="th-sm">Consignee Hours</th>
                            <th class="th-sm">Consignee Appointment</th>
                            <th class="th-sm">Consignee Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$consignee->consignee_address_two}}</td>
                            <td>{{$consignee->consignee_address_three}}</td>
                            <td>{{$consignee->consignee_fax}}</td>
                            <td>{{$consignee->consignee_hours}}</td>
                            <td>{{$consignee->consignee_appointments}}</td>
                            <td>{{$consignee->consignee_status}}</td>
                        </tr>
                    </tbody>
                </table>

            </td>



        </tr>

        @endforeach
    </tbody>
</table>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-<base64-encoded-integrity-value>"
    crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"
    integrity="sha384-<base64-encoded-integrity-value>" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"
    integrity="sha384-<new-generated-integrity-value>" crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/mdbootstrap/js/mdb.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->

<script>
    $(document).ready(function () {
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });

</script>
<script>
    function deleteConsignee(consigneeId) {
        if (confirm('Are you sure you want to delete this consignee?')) {
            document.getElementById('deleteForm' + consigneeId).submit();
        }
    }

</script>
<script>
    $(document).ready(function () {
        $(".toggle-button").click(function () {
            // Find the closest table with class 'additional-data' relative to the clicked button
            var additionalData = $(this).closest("td").find(".additional-data");
            additionalData.toggle();
        });
    });

</script>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    adjustPageSize();
  });

  function adjustPageSize() {
    document.body.style.zoom = "70%";
  }
</script>
@stop
