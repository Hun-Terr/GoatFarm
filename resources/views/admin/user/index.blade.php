@extends('layouts.admin')

@section('css')

    <link rel="stylesheet" href="{{asset("assets/modules/datatables/datatables.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css")}}">
@endsection
@section('content')
    <div class="section-header">
        <h1>Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Users</a></div>
            <div class="breadcrumb-item">Index</div>

        </div>
    </div>


    <div class="section-body">

<div class="row">
    <div class="col-lg-12 margin-tb">

        <div class="float-right">
            <a class="btn btn-success" href="{{ route('user.create') }}"> Create New User</a>
        </div>
    </div>
</div>
<p></p>

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Users</h4>

                    </div>
                    <div class="card-body">

    <div class="table-responsive">
      <table id="table1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th width="280px">Action</th>

        </tr>
        </thead>
       <tbody>
        @foreach ($data as $key => $user)
        <tr>
          <td>{{ $key+1 }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>

          <td>
              {!! Form::open(['method' => 'DELETE','route' => ['user.destroy', $user->id],'style'=>'display:inline']) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
              {!! Form::close() !!}
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

@endsection
@section('js')

    <script src="{{asset("/assets/js/page/components-table.js")}}"></script>
    <script src="{{asset("assets/modules/datatables/datatables.min.js")}}"></script>
    <script src="{{asset("assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{asset("assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js")}}"></script>
    <script src="{{asset("assets/js/page/modules-datatables.js")}}"></script>
    <script src="{{asset("assets/modules/jquery-ui/jquery-ui.min.js")}}"></script>
<script>
  $(function () {

    $('#table1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true,

    })
  })
</script>
@endsection
