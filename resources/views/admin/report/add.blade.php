@extends('layouts.admin')

@section('content')
    <div class="section-header">
        <h1>Add Report</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('report.index')}}">Reports</a></div>
            <div class="breadcrumb-item">Add Report</div>

        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Adding Report</h2>
        <p class="section-lead">
            Here you can add notes and summarize all the details.
        </p>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <h4>Add new Report</h4>
        </div>
        <div class="card-body">

            {!! Form::open(array('route' => 'report.store','method'=>'POST','enctype' => 'multipart/form-data')) !!}
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <strong>Title :</strong>
                        {!! Form::text('title', null ,array('id'=>'title','class' => 'form-control' , 'required')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Report Date :</strong>
                        {!! Form::date('report_date', old('date', now()->toDateString()), array('id'=>'report_date','class' => 'form-control' ,'required')) !!}
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10">
                    <div class="form-group">
                        <strong>Report Content:</strong>
                        {!! Form::textarea('description',null, array('placeholder' => 'Enter The Content','class' => 'form-control' ,)) !!}
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

                <div class="col-xs-12 col-sm-12 col-md-4" >
                    <div class="form-group">
                        <strong>Link to Goat ? </strong>
                        {!! Form::select('goat_id',['' => 'Select a Goat'] + $goats->pluck('name', 'id')->toArray(), $goat_link_id ,array('id'=>'goat_id','class' => 'form-control' , 'single')) !!}
                    </div>
                </div>
                <input type="hidden" name="goat_id" id="h_goat_id" value="">

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
    $(document).ready(function() {
        // Add the 'resize-vertical' class to all textarea elements
        $('textarea').addClass('resize-vertical');

        // Apply the CSS styles directly (if needed)
        $('textarea.resize-vertical').css('resize', 'both');

        var goat_link_value = @json($goat_link_id);
        console.log(goat_link_value);

        if (goat_link_value != null) {
            $("#goat_id").prop("disabled", true);
            $("#h_goat_id").val(goat_link_value);
        } else {
            $('#goat_id').val('');
        }

        $('#goat_id').on('change',function(){

            $("#h_goat_id").val($('#goat_id').val());

        });

    });

</script>
@endsection
