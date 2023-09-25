@extends('layouts.admin')

@section('content')
    <div class="section-header">
        <h1>Add Customer</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('customer.index')}}">Customers</a></div>
            <div class="breadcrumb-item">Add Customer</div>

        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Adding Customer</h2>
        <p class="section-lead">
            Here you can add buyer of your Goats and Products.
        </p>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <h4>Add new Customer</h4>
        </div>
        <div class="card-body">

            {!! Form::open(array('route' => 'customer.store','method'=>'POST')) !!}
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <strong>Name :</strong>
                        {!! Form::text('name', null ,array('placeholder'=> 'Enter the Name','id'=>'name','class' => 'form-control' , 'required')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <strong>Contact Information :</strong>
                        {!! Form::text('contact_information', null ,array('placeholder'=> 'Enter Contact Details','id'=>'contact_information','class' => 'form-control' , 'required')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <strong>Address :</strong>
                        {!! Form::textarea('address', null ,array('placeholder'=> 'Enter the Address','id'=>'address','class' => 'form-control' , 'required')) !!}
                    </div>
                </div>

            </div>


            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>

        </div>
            {!! Form::close() !!}

        </div>
    </div>



@endsection

@section('js')
<script>

</script>
@endsection
