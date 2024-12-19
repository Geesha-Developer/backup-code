@extends('adminlte::page')

@section('header_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@stop


@section('content')
<table class="table table-responsive" id="data_table" class="display">
    <thead>
        <tr>
            <th scope="col">Sr No.</th>
            <th scope="col">Carrier Name</th>
            <th scope="col">MC/FF No</th>
            <th scope="col">Load Type</th>
            <th scope="col">Address</th>
            <th scope="col">City</th>
            <th scope="col">State</th>
            <th scope="col">Zip</th>
            <th scope="col">Telephone</th>
            <th scope="col">Status</th>
            <th scope="col">Date Added</th>
            <th scope="col">Added By User</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach($fetch as $f)
        <tr>
            <th scope="row"><?php echo $i++; ?></th>
            <td>{{ $f->carrier_name }}</td>
            <td>{{ $f->carrier_mc_ff }}</td>
            <td>{{ $f->carrier_load_type }}</td>
            <td>{{ $f->carrier_address }}</td>
            <td>{{ $f->carrier_city }}</td>
            <td>{{ $f->carrier_state }}</td>
            <td>{{ $f->carrier_zip }}</td>
            <td>{{ $f->carrier_telephone }}</td>
            <td>{{ $f->carrier_status }}</td>
            <td>{{ $f->created_at }}</td>
            <td>{{ Auth::user()->name }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="event.preventDefault(); document.getElementById('delete-form-{{$f->id}}').submit();">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                <form id="delete-form-{{$f->id}}" action="{{ route('delete_external', ['id' => $f->id]) }}"
                    method="POST" style="display: none;">
                    @csrf
                </form>
                <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#data_table').DataTable();
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