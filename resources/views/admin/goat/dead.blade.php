@extends('layouts.admin')

@section('content')
    <div class="section-header">
        <h1>Dead Goat</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('goat.index')}}">Goats</a></div>
            <div class="breadcrumb-item">Dead Goat</div>

        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Goat is dead</h2>
        <p class="section-lead">
            Here you can do entry if any goat has died.
        </p>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <h4>Remove Goat</h4>
        </div>
        <div class="card-body">

            {!! Form::open(array('route' => 'goat.remove','method'=>'POST','enctype' => 'multipart/form-data')) !!}

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Name :</strong>
                        {!! Form::text('name', $goat->name, array('style' => "text-transform: uppercase;",'id' => 'name' ,'class' => 'form-control' ,'disabled')) !!}
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="{{$goat->id}}">

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Date Of Death:</strong>
                        {!! Form::date('date_of_death', old('date', now()->toDateString()), array('id'=>'date_of_death','class' => 'form-control' ,'required')) !!}
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Upload a Photo:</strong>
                        {!! Form::file('image', array('placeholder' => 'image','class' => 'form-control-file form-control' ,)) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10">
                    <div class="form-group">
                        <strong>Report Description:</strong>
                        {!! Form::textarea('description',null, array('placeholder' => 'Enter The Description','class' => 'form-control' ,'required')) !!}
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
