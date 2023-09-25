@extends('layouts.admin')

@section('content')



    <div class="section-header">
        <h1>Customer</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('customer.index')}}">Customers</a></div>
            <div class="breadcrumb-item">Index</div>
        </div>
    </div>


    <div class="section-body">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Goat Customers</h4>
                        <div class="row col ">
                            <div class="col-lg-12">
                                <div class="float-right">
                                    <a class="btn btn-success" href="{{route("customer.add")}}"> Add New Customer</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th width="280px">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $key => $user)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->contact_information }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            <a class="btn btn-info disabled" href="#">Show</a>
                                            <a class="btn btn-primary" href={{route('customer.edit',$user->id)}}>Edit</a>
                                            {!! Form::open(['method' => 'DELETE','route' => ['customer.delete', $user->id],'style'=>'display:inline']) !!}
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
    </div>

@endsection
