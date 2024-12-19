@extends('adminlte::page')

@section('content_header')
<!-- <h1>Carrier List Page</h1> -->
@stop

@section('content')
<table class="table table-resposive">
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
            <th scope="col">Approval Status</th>
            <th scope="col">Date Added</th>
            <th scope="col">Added By User</th>
            <th scope="col">Team Lead</th>
            <th scope="col">Team Manager</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach($fetch as $f)
        <tr>
            <th scope="row">{{ $i++ }}</th>
            <td>{{ $f->customer_name }}</td>
            <td>{{ $f->customer_id }}</td>
            <td>{{ $f->customer_mc_ff }}</td>
            <td>{{ $f->customer_mc_ff_input }}</td>
            <td>{{ $f->customer_address }}</td>
            <td>{{ $f->customer_country }}</td>
            <td>{{ $f->customer_city }}</td>
            <td>{{ $f->customer_zip }}</td>
            <td>{{ $f->customer_billing_address }}</td>
            <td>{{ $f->customer_primary_contact}}</td>
            <td>{{ $f->customer_billing_country }}</td>
            <td>{{ $f->customer_billing_state }}</td>
            <td>{{ $f->customer_billing_city}}</td>
            <td>{{ $f->customer_billing_zip}}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="event.preventDefault(); document.getElementById('delete-form-{{$f->id}}').submit();">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                <form id="delete-form-{{$f->id}}" action="{{ route('delete.customer', ['id' => $f->id]) }}"
                    method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
                <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection
@section('js')
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    adjustPageSize();
  });

  function adjustPageSize() {
    document.body.style.zoom = "70%";
  }
</script>