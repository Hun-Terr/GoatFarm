@extends('layouts.admin')


@section('content')

    <div class="section-header">
        <h1>Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></div>
            <div class="breadcrumb-item">Show</div>

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



    <div class="card">

        <div class="card-header">
            <h4>User Detail</h4>
        </div>
        <div class="card-body">
            <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $user->name }}
        </div>
    </div>
    <div class=" col-md-6">
        <div class="form-group">
            <strong>Email:</strong>
            {{ $user->email }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Roles:</strong>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                @endforeach
            @endif
        </div>
    </div>
</div>
    </div>
    </div>
</div>


@endsection
