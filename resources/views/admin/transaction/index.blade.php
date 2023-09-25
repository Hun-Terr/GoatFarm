@extends('layouts.admin')
@section('css')
    <style>
        /* Add custom styles to the modal */
        .modal-backdrop {
            position: relative;
            z-index: -1;
        }
    </style>
@endsection

@section('content')


    <div class="section-header">
        <h1>Transaction</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('transaction.index')}}">Transactions</a></div>
            <div class="breadcrumb-item">Index</div>
        </div>
    </div>


    <div class="section-body">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <!-- Modal HTML -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 600px;">
                    <div class="modal-content" style="background-color: #efebff;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalHeader">Modal Title</h5>

                            <button type="button" class="btn btn-secondary" style="background-color: black;" data-dismiss="modal"><span >&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div id="myModalBody" style="height: auto; overflow-y: auto; overflow-x: hidden;">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" style="background-color: black;" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Farm Transactions</h4>
                        <div class="row col ">
                            <div class="col-lg-12">
                                <div class="float-right">
                                    <a class="btn btn-success" href="{{route("transaction.add")}}"> Add New Transaction</a>
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
                                    <th>Transaction Date</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th width="280px">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $key => $user)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->transaction_date)->format('d-m-Y')}}</td>
                                        <td>{{ $user->type }}</td>
                                        <td>{{ $user->description }}</td>
                                        <td style="text-wrap: nowrap;">
                                            @if($user->type == 'sale')
                                                <span style="color: green ">
                                                    +  {{ $user->amount }}
                                                </span>
                                            @else
                                                <span style="color: red">
                                                    -  {{ $user->amount }}
                                                </span>
                                            @endif


                                        </td>
                                        <td>
                                            <a class="btn btn-info show-transaction" data-transaction="{{ json_encode($user) }}" href="#">Show</a>
                                            <a class="btn btn-primary disabled" href="#">Edit</a>
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

@section('js')

    <!-- Page Specific JS File -->
    <script src="{{asset("assets/js/page/bootstrap-modal.js")}}"></script>
    <script src="{{asset("assets/modules/prism/prism.js")}}"></script>

    <script>

        $(document).ready(function() {
          //  $('#myModal').modal('show');

        });

        $('.show-transaction').click(function() {
            const transactionData = $(this).data('transaction');
            //console.log(transactionData);
            populateModal(transactionData);
            $('#myModal').modal('show');

            function populateModal(data) {
                const modalHeader = $('#myModalHeader');
                modalHeader.empty();

                // Create a title for the modal header (customize this part as needed)
                modalHeader.html('<h4>Transaction Details</h4>');

                const modalBody = $('#myModalBody');
                modalBody.empty();

                // Goat Card (if goat data is present)
                if (data.goat) {
                    modalBody.append('<div class="card"><div class="card-header form-control-lg">Goat</div><div class="card-body">' +
                        '<div class="row">' +
                        '<div class="col-12 col-md-6 col-lg-4">' +
                        '<p><strong>Is Active:</strong> ' + (data.goat.is_active === 1 ? '<span class="badge badge-success mb-1 ml-3">Yes</span>' : '<span class="badge badge-danger mb-1 ml-3">No</span>') + '</p>' +
                        (data.goat.image ? '<div class="pt-2"><img src="{{ asset("/images") }}/' + data.goat.image + '" alt="Goat Image" width="100"></div>' : '') +
                        '</div>' +
                        '<div class="col-12 col-md-6 col-lg-8">' +
                        '<a href="{{ route("goat.index") }}" class="btn btn-primary mb-4">View Goat</a>' +
                        '<p><strong>Name:</strong> ' + data.goat.name + '</p>' +
                        '<p><strong>Gender:</strong> ' + data.goat.gender + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div></div>');
                }

                // Transaction Card
                modalBody.append('<div class="card"><div class="card-header form-control-lg">Transaction</div><div class="card-body">' +
                    '<div class="row">' +
                    '<div class="col-4"><strong>Date:</strong> ' +new Date(data.transaction_date).toJSON().slice(0,10).split('-').reverse().join('/') + '</div>' +
                    '<div class="col-4"><strong>Type:</strong> ' + data.type + '</div>' +
                    '<div class="col-4"><strong>Amount:</strong>' + data.amount + '</div>' +
                    '</div>' +
                    '<p class="mt-3" ><strong>Description:</strong> ' + data.description + '</p>' +
                    '</div></div>');

                // Report Card (if report data is present)
                if (data.report) {
                    modalBody.append('<div class="card"><div class="card-header form-control-lg">Report</div><div class="card-body">' +
                        '<div class="row">' +
                        '<div class="col-12 col-md-6 col-lg-' + (data.report.image ? '4' : '12') + '">' +
                        (data.report.image ? '<div class=""><img src="{{ asset("/images") }}/' + data.report.image + '" alt="Report Image" width="100"></div>' : '') +
                        '</div>' +
                        '<div class="col-12 col-md-6 col-lg-' + (data.report.image ? '8' : '12') + '">' +
                        '<a href="{{ route("report.index") }}" class="btn btn-primary mb-4">View Report</a>' +
                        '<p><strong>Report Date:</strong> ' + new Date(data.report.report_date).toJSON().slice(0, 10).split('-').reverse().join('/') + '</p>' +
                        '<p><strong>Title:</strong> ' + data.report.title + '</p>' +
                        '<p><strong>Content:</strong> ' + data.report.content + '</p>' +
                        '</div>' +
                        '</div></div>');
                }

                // Customer Card (if customer data is present)
                if (data.customer) {
                    modalBody.append('<div class="card"><div class="card-header form-control-lg">Customer</div><div class="card-body">' +
                        '<div class="row">' +
                        '<div class="col-12 col-md-6 col-lg-5">' +
                        '<p><strong>Name:</strong> ' + data.customer.name + '</p>' +
                        '</div>' +
                        '<div class="col-12 col-md-6 col-lg-7">' +
                        '<p><strong>Contact Information:</strong> ' + data.customer.contact_information + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div></div>');
                }

            }

        });

    </script>



@endsection
