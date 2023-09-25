@extends('layouts.admin')


@section('content')


    <div class="section-header">
        <h1>Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></div>
            <div class="breadcrumb-item">Edit</div>

        </div>
    </div>


    <div class="section-body">

        <div class="row">
            <div class="col-lg-12 margin-tb">

                <div class="float-right">
                    <a class="btn btn-success" href="{{ route('users.index') }}"> Back</a>
                </div>
            </div>
        </div>
        <p></p>

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>

  </div>
@endif

        <div class="card">

            <div class="card-header">
                <h4>Edit User</h4>
            </div>
            <div class="card-body">
{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-7">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', $user->name, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
        @if ($errors->has('name'))
        <div class="alert alert-danger">
          <ul>
             @foreach ($errors->get('name') as $error)
               <li>{{ $error }}</li>
             @endforeach
          </ul>
        </div>
        @endif
    </div>


    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
        @if ($errors->has('password'))
        <div class="alert alert-danger">
          <ul>
             @foreach ($errors->get('password') as $error)
               <li>{{ $error }}</li>
             @endforeach
          </ul>
        </div>
        @endif
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
        </div>
        @if ($errors->has('confirm-password'))
        <div class="alert alert-danger">
          <ul>
             @foreach ($errors->get('confirm-password') as $error)
               <li>{{ $error }}</li>
             @endforeach
          </ul>
        </div>
        @endif
    </div>
    <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','single')) !!}
        </div>

    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary float-right">Submit</button>
    </div>
</div>
{!! Form::close() !!}



    </div>
    </div>
</div>
</section>
@endsection
@section('js')
<script>
  $(document).ready(function() {

      $(function() {
          $( "#dob" ).datepicker();
      });
  })
</script>
@endsection
