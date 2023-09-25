@extends('layouts.admin')

@section('content')
    <div class="section-header">
        <h1>Add Transaction</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('transaction.index')}}">Transactions</a></div>
            <div class="breadcrumb-item">Add Transaction</div>

        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Adding Transaction</h2>
        <p class="section-lead">
            Here you can Add Expenses and Income of your Farm to track Balance Sheet.
        </p>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <h4>Add new Transaction</h4>
        </div>
        <div class="card-body">

            {!! Form::open(array('route' => 'transaction.store','method'=>'POST','enctype' => 'multipart/form-data')) !!}
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Date Of Transaction:</strong>
                        {!! Form::date('transaction_date', old('date', now()->toDateString()), array('id'=>'transaction_date','class' => 'form-control' ,'required')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4" >
                    <div class="form-group">
                        <strong>Type :</strong>
                        {!! Form::select('type', $transaction_types, null ,array('id'=>'type','class' => 'form-control' , 'single','required')) !!}
                    </div>
                </div>
                <input type="hidden" name="type" id="h_type" value="">

                <div class="col-xs-12 col-sm-12 col-md-4" >
                    <div class="form-group">
                        <strong>Amount :</strong>
                        {!! Form::number('amount', null, array('id'=>'amount','class' => 'form-control','required')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-10">
                    <div class="form-group">
                        <strong>Description:</strong>
                        {!! Form::textarea('description',null, array('placeholder' => 'Enter The Description','class' => 'form-control' ,)) !!}
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-4 sellclass" >
                    <div class="form-group">
                        <strong>Goat Id :</strong>
                        {!! Form::select('goat_id', $goats->pluck('name','id'), $sell_goat_id ,array('id'=>'goat_id','class' => 'form-control' , 'single')) !!}
                    </div>
                </div>

                <input type="hidden" name="goat_id" id="h_goat_id" value="">

                <div class="col-xs-12 col-sm-12 col-md-4 sellclass" >
                    <div class="form-group">
                        <strong>Customer Id :</strong>
                        {!! Form::select('customer_id', $customers->pluck('name','id'), null ,array('id'=>'customer_id','class' => 'form-control' , 'single')) !!}
                    </div>
                </div>
                <a class="mt-4 sellclass" href="{{route('customer.add')}}">Add new Customer</a>

            </div>

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Upload a Photo:</strong>
                        {!! Form::file('image', array('placeholder' => 'image','class' => 'form-control-file form-control' ,)) !!}
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

            $('#type').val('');

            var sell_goat_value = @json($sell_goat_id);
            console.log(sell_goat_value);
            if (sell_goat_value != null) {
                $("#goat_id").prop("disabled", true);
                $("#type").prop("disabled", true);
                $("#type").val('sale');
                $("#h_type").val('sale');
                $("#h_goat_id").val(sell_goat_value);
            } else {
                $('#goat_id').val('');
                $(".sellclass").hide();
            }

        });

        $(function() {

            $('#type').on('change',function(){
                if( $(this).val()==="sale"){
                    $(".sellclass").show();
                    $("#goat_id").prop("required", true);
                }
                else{
                    $(".sellclass").hide();
                    $("#goat_id").removeAttr("required");
                }
            });
        });

    </script>
@endsection
