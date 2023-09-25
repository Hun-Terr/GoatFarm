@extends('layouts.admin')

@section('content')
    <div class="section-header">
        <h1>Add Goat</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('goat.index')}}">Goats</a></div>
            <div class="breadcrumb-item">Add Goat</div>

        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Adding Goat</h2>
        <p class="section-lead">
            Here you can Add Goats based on weather you buy them or they are born.
        </p>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <h4>Add new Goat</h4>
        </div>
        <div class="card-body">

            {!! Form::open(array('route' => 'goat.store','method'=>'POST','enctype' => 'multipart/form-data')) !!}
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <strong>Reason To Add:</strong>
                        <div class="selectgroup w-100 mt-2">
                            <label class="selectgroup-item">
                                <input type="radio" name="type" id="type_born" value="born" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Born</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="type" id="type_buy" value="buy" class="selectgroup-input">
                                <span class="selectgroup-button">Buy</span>
                            </label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="type" id="h_type" value="">

            </div>


            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-4 bornclass" >
                    <div class="form-group">
                        <strong>Mother :</strong>
                        {!! Form::select('mother_id', $mothers->pluck('name','id'), $mother_id ,array('id'=>'mother_id','class' => 'form-control' , 'single')) !!}
                    </div>
                </div>
                <input type="hidden" name="mother_id" id="h_mother_id" value="">

                <div class="col-xs-12 col-sm-12 col-md-4 bornclass" >
                    <div class="form-group">
                        <strong>Father :</strong>
                        {!! Form::select('father_id', $fathers->pluck('name','id'), null ,array('id'=>'father_id','class' => 'form-control' , 'single')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 buyclass"  style="display:none">
                    <div class="form-group">
                        <strong>Date Of Purchase:</strong>
                        {!! Form::date('purchase_date', old('date', now()->toDateString()), array('class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 buyclass"  style="display:none">
                    <div class="form-group">
                        <strong>Amount :</strong>
                        {!! Form::number('amount', null, array('id'=>'amount','class' => 'form-control')) !!}
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Gender :</strong>
                        {!! Form::select('gender', array('male'=>'Male' ,'female'=> 'Female'), null ,array('id'=>'gender','class' => 'form-control' , 'single','required')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Breed:</strong>
                        {!! Form::text('breed', null, array('placeholder' => 'Breed','class' => 'form-control' ,)) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Date Of Birth:</strong>
                        {!! Form::date('dob', old('date', now()->toDateString()), array('id'=>'dob','class' => 'form-control' ,'required')) !!}
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Name :</strong>
                        {!! Form::text('name', null, array('style' => "text-transform: uppercase;",'id' => 'name' ,'class' => 'form-control' ,'required')) !!}
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
                        {!! Form::textarea('description',null, array('placeholder' => 'Enter The Description','class' => 'form-control' ,)) !!}
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

        $(document).ready(function() {
            // Add the 'resize-vertical' class to all textarea elements
            $('textarea').addClass('resize-vertical');

            // Apply the CSS styles directly (if needed)
            $('textarea.resize-vertical').css('resize', 'both');

            $('#father_id').val('');
            $('#gender').val('');
            $('#h_type').val('born');


            var mother_id_value = @json($mother_id);
            console.log(mother_id_value);

            if (mother_id_value != null) {
                $("#type_born").prop('disabled', true);
                $("#type_buy").prop('disabled', true);
                $("#mother_id").prop("disabled", true);
                $("#h_mother_id").val(mother_id_value);
                var selectedText = $("#mother_id").find("option:selected").text();
                $("#name").val(selectedText);
            } else {
                $('#mother_id').val('');
            }

            // Attach a change event handler to the radio buttons
            $("input[name='type']").change(function() {
                // Check the value of the selected radio button
                var selectedValue = $("input[name='type']:checked").val();

                $('#name').val('');
                // Perform actions based on the selected value
                if (selectedValue === "born") {
                    $(".buyclass").hide()
                    $(".bornclass").show()
                    $("#amount").removeAttr("required");
                    $('#h_type').val('born');
                } else if (selectedValue === "buy") {
                    $(".buyclass").show()
                    $(".bornclass").hide()
                    $('#dob').val('');
                    $("#amount").prop("required", true);
                    $('#mother_id').val('');
                    $('#father_id').val('');
                    $('#h_type').val('born');
                }
            });

            $("#mother_id").change(function() {

                var selectedText = $(this).find("option:selected").text();
                $("#name").val(selectedText);

                $("#h_mother_id").val($('#mother_id').val());

            });


            $('form').submit(function() {
                // Transform the input value to uppercase before submission
                $("#name").val($("#name").val().toUpperCase());
            });


        });
    </script>
@endsection
