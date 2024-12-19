@extends('adminlte::page')

@section('content_header')
<!-- <h1>Shipper List Page</h1> -->
@stop

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
<table class="table table-striped">
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
        <td>{{ $f->shipper_name }}</td>
        <td>{{ $f->shipper_address }}</td>
        <td>{{ $f->shipper_address_two }}</td>
        <td>{{ $f->shipper_address_three }}</td>
        <td>{{ $f->shipper_country }}</td>
        <td>{{ $f->shipper_state }}</td>
        <td>{{ $f->shipper_city }}</td>
        <td>{{ $f->shipper_zip }}</td>
        <td>{{ $f->shipper_contact_name }}</td>
        <td>{{ $f->shipper_contact_email }}</td>
        <td>{{ $f->shipper_telephone }}</td>
        <td>{{ $f->shipper_extn }}</td>
        <td>{{ $f->shipper_toll_free }}</td>
        <td>{{ $f->shipper_fax }}</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger"
                onclick="event.preventDefault(); document.getElementById('delete-form-{{$f->id}}').submit();">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
            <form id="delete-form-{{$f->id}}" action="{{ route('delete.shipper', ['id' => $f->id]) }}"
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
