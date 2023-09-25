@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{asset("assets/modules/prism/prism.css")}}">

    <style>
        /* Add custom styles to the modal */
        .modal-backdrop {
            position: relative;
            z-index: -1
        }
    </style>
@endsection

@section('content')


    <div class="section-header">
        <h1>Reports</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('report.index')}}">Reports</a></div>
            <div class="breadcrumb-item">Index</div>

        </div>
    </div>

    <div class="row col mb-4">
        <div class="col-lg-12">
            <div class="float-right">
                <a href="#" id="viewAllReports" class="btn btn-primary">View All</a>
                <a class="btn btn-success" href="{{route("report.add",['goat_link_id'=>'0'])}}"> Add Report</a>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px;">
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


<div class="section-body">

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">

            @foreach($data as $key => $t)

                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{$t->title}}</h4>
                        <div class="card-header-action">
                            <div style="    float: left; margin-right: 55px;">
                                {{ \Carbon\Carbon::parse($t->report_date)->format('d-m-Y')}}
                            </div>
                            <a class="btn btn-primary view-report" data-report="{{ json_encode($t) }}" href="#"><i class="fa fa-solid fa-eye"></i></a>
                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Options</a>
                                <div class="dropdown-menu">
                                    @if($t->goat != null)
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-horse"></i> Go to {{$t->goat->name}}</a>
                                    @endif
                                    <a href={{route('report.edit',$t->id)}} class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                                    <div class="dropdown-divider"></div>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['report.delete', $t->id], 'style' => 'display:inline']) !!}
                                        <button type="submit" class="dropdown-item has-icon text-danger" style=" padding: 10px 20px; line-height: 1.2; font-size: 13px;"><i class="far fa-trash-alt"></i> Delete</button>
                                        {!! Form::close() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($t->image != null)
                                <div class="col-12 col-md-12 col-lg-4" style=" margin-right: -70px; margin-left: 15px;  margin-bottom: 15px; ">
                                    <img src="{{asset('/images').'/'.$t->image }}"  width="100">
                                </div>
                            @endif
                            <div class="col-12 col-md-12 col-lg-8">
                                <p>{{$t->content}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>

</div>

@endsection

@section('js')
    <!-- Page Specific JS File -->
    <script src="{{asset("assets/js/page/bootstrap-modal.js")}}"></script>
    <script src="{{asset("assets/modules/prism/prism.js")}}"></script>

    <script>

        $('.view-report').click(function() {
            const reportData = $(this).data('report');
             populateModal(reportData);

            $('#myModal').modal('show');

            function populateModal(reportData) {
                const modalHeader = $('#myModalHeader');
                // Clear previous content
                modalHeader.empty();
                var new_date =new Date(reportData.report_date).toJSON().slice(0,10).split('-').reverse().join('/')

                modalHeader.append('<p><span style="font-size: small;">   ' + new_date + '</span> <span class="ml-5">' + reportData.title + '</span></p>');



                const modalBody = $('#myModalBody');
                // Clear previous content
                modalBody.empty();
                // Create a row div
                const rowDiv = $('<div class="row">');

                if (reportData.image) {
                    // Create a col-4 div for the image
                    const imageDiv = $('<div class="col-4 col-md-4 pl-5">');
                    const imageTag = $('<img>').attr({
                        src: '{{ asset("images/") }}/' + reportData.image,
                        alt: 'Report Image',
                        width: '200',
                    });
                    imageDiv.append(imageTag);
                    rowDiv.append(imageDiv);

                    // Create a col-8 div for the report content
                    const contentDiv = $('<div class="col-8 col-md-8">');
                    contentDiv.text(reportData.content); // Use text() to set text content
                    rowDiv.append(contentDiv);


                }else{
                    const contentDiv = $('<div class="col-12 col-md-12 ml-3">');
                    contentDiv.text(reportData.content); // Use text() to set text content
                    rowDiv.append(contentDiv);
                }

// Append the row div to the modal body
                modalBody.append(rowDiv);

                if(reportData.goat){
                    if (reportData.goat) {
                        // Create a button with the goat's name
                        const goatButton = $('<a>').attr({
                            href: '{{ route("goat.index") }}', // Replace with your route
                            class: 'btn btn-primary ml-5 mt-3',
                        });
                        goatButton.text(reportData.goat.name);
                        rowDiv.append(goatButton);
                    }
                }

                modalBody.append(rowDiv);


            }
        });

    </script>

    <script>
        // When the "View All" button is clicked
        $('#viewAllReports').click(function() {
            compileAndDisplayReports();
        });

        // Function to compile and display all reports' content
        function compileAndDisplayReports() {

            const modalHeader = $('#myModalHeader');
            // Clear previous content
            modalHeader.empty();

            modalHeader.append('All Reports');


            let compiledContent = '';

            // Loop through each report and add its content to the compiled content
            @foreach($data as $t)
                compiledContent += '<div class="card card-primary">';
            compiledContent += '<div class="card-header">';
            compiledContent += '<h4>{{ $t->title }}</h4>';
            compiledContent += '<div class="card-header-action">';
            compiledContent += '<div style="float: left; margin-right: 55px;">{{ \Carbon\Carbon::parse($t->report_date)->format('d-m-Y') }}</div>';
            compiledContent += '</div>';
            compiledContent += '</div>';
            compiledContent += '<div class="card-body">';
            compiledContent += '<div class="row">';
            @if($t->image != null)
                compiledContent += '<div class="col-12 col-md-12 col-lg-4" style="margin-right: -70px; margin-left: 15px; margin-bottom: 15px;">';
            compiledContent += '<img src="{{ asset('/images') }}/{{ $t->image }}" width="100">';
            compiledContent += '</div>';
            @endif
                compiledContent += '<div class="col-12 col-md-12 col-lg-8">';
            compiledContent += '<p>{{ $t->content }}</p>';
            compiledContent += '</div>';
            compiledContent += '</div>';
            compiledContent += '</div>';
            compiledContent += '</div>';
            @endforeach

            // Display the compiled content in the modal's body
            $('#myModalBody').html(compiledContent);

            // Show the modal
            $('#myModal').modal('show');
        }
    </script>

@endsection
