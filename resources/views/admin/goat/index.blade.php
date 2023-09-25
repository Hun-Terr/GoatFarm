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
        <h1>Goats</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('goat.index')}}">Goats</a></div>
            <div class="breadcrumb-item">Index</div>

        </div>
    </div>

    <!-- Modal HTML -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 720px;">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Active Goats</h4>
                        <div class="row col ">
                            <div class="col-lg-12">
                                <div class="float-right">
                                    <a class="btn btn-success" href="{{route("goat.add")}}"> Add Goat</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all_goat_tab" data-toggle="tab" href="#all_goat" role="tab" aria-controls="all_goat" aria-selected="true">All Goats</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="male_goat_tab" data-toggle="tab" href="#male_goat" role="tab" aria-controls="male_goat" aria-selected="false">Male Goats</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="female_goat_tab" data-toggle="tab" href="#female_goat" role="tab" aria-controls="female_goat" aria-selected="false">Female Goats</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="all_goat" role="tabpanel" aria-labelledby="all_goat_tab">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th width="280px">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($goats as $key => $user)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->gender }}</td>
                                                <td>
                                                    {{ date_diff(new \DateTime($user->date_of_birth), new \DateTime())->format("%y Years %m Months") }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-info view-goat" data-id="{{ json_encode($user->id) }}"   href="#"><i class="fa fa-solid fa-eye"></i></a>
                                                    <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Options</a>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="disabled dropdown-item has-icon "><i class="far fa-edit"></i> Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{route("report.add",['goat_link_id'=>$user->id])}}" class="dropdown-item has-icon"><i class="far fa-plus-square"></i> Add Report</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{route("transaction.add",['sell_goat_id'=>$user->id])}}" class="dropdown-item has-icon"><i class="far fa-solid fa-money-bill-alt"></i> Sale</a>
                                                        <a href="{{route("goat.dead",['id'=>$user->id])}}" class="dropdown-item has-icon text-danger"><i class="far fa-stop-circle"></i> Dead</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="male_goat" role="tabpanel" aria-labelledby="male_goat_tab">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th width="280px">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($males as $key => $user)
                                            <tr>
                                                <td>{{ $key+1 }}
                                                    @if(! $user->is_castrated)
                                                        <i class="fas fa-crown"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>
                                                    {{ date_diff(new \DateTime($user->date_of_birth), new \DateTime())->format("%y Years, %m Months") }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-info view-goat" data-id="{{ json_encode($user->id) }}" href="#"><i class="fa fa-solid fa-eye"></i></a>
                                                    <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Options</a>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="disabled dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{route("report.add",['goat_link_id'=>$user->id])}}" class="dropdown-item has-icon"><i class="far fa-plus-square"></i> Add Report</a>
                                                        <div class="dropdown-divider"></div>
                                                        @if(!$user->is_castrated)
                                                            <a href="{{route("goat.castrate",['id'=>$user->id])}}" class="dropdown-item has-icon"><i class="far fa-solid fa-hand-scissors"></i> Castrate</a>
                                                        @endif
                                                        <a href="{{route("transaction.add",['sell_goat_id'=>$user->id])}}" class="dropdown-item has-icon"><i class="far fa-solid fa-money-bill-alt"></i> Sale</a>
                                                        <a href="{{route("goat.dead",['id'=>$user->id])}}" class="dropdown-item has-icon text-danger"><i class="far fa-stop-circle"></i> Dead</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="female_goat" role="tabpanel" aria-labelledby="female_goat_tab">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Days after Last Child</th>
                                            <th width="280px">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($females as $key => $user)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>
                                                    {{ date_diff(new \DateTime($user->date_of_birth), new \DateTime())->format("%y Years, %m Months") }}
                                                </td>
                                                <td>{{$user->last_child_diff}}</td>
                                                <td>
                                                    <a class="btn btn-info view-goat" data-id="{{ json_encode($user->id) }}" href="#"><i class="fa fa-solid fa-eye"></i></a>
                                                    <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Options</a>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="disabled dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{route("report.add",['goat_link_id'=>$user->id])}}" class="dropdown-item has-icon"><i class="far fa-plus-square"></i> Add Report</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{route("goat.add",['mother_id'=>$user->id])}}" class="dropdown-item has-icon"><i class="far fa-solid fa-smile"></i> Gave Birth</a>
                                                        <a href="{{route("transaction.add",['sell_goat_id'=>$user->id])}}" class="dropdown-item has-icon"><i class="far fa-solid fa-money-bill-alt"></i> Sale</a>
                                                        <a href="{{route("goat.dead",['id'=>$user->id])}}" class="dropdown-item has-icon text-danger"><i class="far fa-stop-circle"></i> Dead</a>
                                                    </div>
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

                <div class="card" style="background-color: #f9f6f6;">
                    <div class="card-header">
                        <h4>InActive Goats</h4>
                    </div>
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="inactive_all_goat_tab" data-toggle="tab" href="#inactive_all_goat" role="tab" aria-controls="inactive_all_goat" aria-selected="true">All Inactive Goats</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dead_goat_tab" data-toggle="tab" href="#dead_goat" role="tab" aria-controls="dead_goat" aria-selected="false">Dead Goats</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sold_goat_tab" data-toggle="tab" href="#sold_goat" role="tab" aria-controls="sold_goat" aria-selected="false">Sold Goats</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="inactive_all_goat" role="tabpanel" aria-labelledby="inactive_all_goat_tab">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Reason</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Last Date</th>
                                            <th width="280px">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($in_active_goats as $key => $user)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>
                                                    @if($user->sale_date != null)
                                                        Sold <i class="fa fa-solid fa-hand-holding-usd"></i>
                                                    @else
                                                        Dead <i class="fa fa-solid fa-skull-crossbones"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->gender }}</td>
                                                <td>
                                                    @if($user->sale_date != null)
                                                        {{ \Carbon\Carbon::parse($user->sale_date)->format('d-m-Y')}}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($user->date_of_death)->format('d-m-Y')}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-info view-goat" data-id="{{ json_encode($user->id) }}" href="#">Show</a>
                                                    <a class="btn btn-primary" href="#">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="dead_goat" role="tabpanel" aria-labelledby="dead_goat_tab">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Date Of Death</th>
                                            <th>LifeSpan</th>
                                            <th width="280px">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($dead_goats as $key => $user)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->gender }}</td>
                                                <td>{{ $user->date_of_death }}</td>
                                                <td>
                                                    {{ date_diff(new \DateTime($user->date_of_death), new \DateTime($user->date_of_birth))->format("%y Years, %m Months") }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-info view-goat" data-id="{{ json_encode($user->id) }}" href="#">Show</a>
                                                    <a class="btn btn-primary" href="#">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sold_goat" role="tabpanel" aria-labelledby="sold_goat_tab">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Sale Date</th>
                                            <th>LifeSpan</th>
                                            <th width="280px">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($sold_goats as $key => $user)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->gender }}</td>
                                                <td>{{ $user->sale_date }}</td>
                                                <td>
                                                    {{ date_diff(new \DateTime($user->sale_date), new \DateTime($user->date_of_birth))->format("%y Years, %m Months") }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-info view-goat" data-id="{{ json_encode($user->id) }}" href="#">Show</a>
                                                    <a class="btn btn-primary" href="#">Edit</a>
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



        </div>
    </div>

@endsection
@section('js')
    <!-- Page Specific JS File -->
    <script src="{{asset("assets/js/page/bootstrap-modal.js")}}"></script>
    <script src="{{asset("assets/modules/prism/prism.js")}}"></script>


    <script>
        // Use delegated event binding to handle clicks on dynamically loaded buttons
        $(document).on('click', '.view-goat', function() {
            const id = $(this).data('id');
            console.log('clicked');
            var url = '{{ route("fetchDetails", ":id") }}';
            url = url.replace(':id', id);
            // Use AJAX to fetch data based on 'type' and 'id'
            $.ajax({
                url: url ,
                method: 'GET',
                success: function(data) {
                    // Handle the fetched data and populate the modal
                    console.log(data)
                    populateModal(data);
                    $('#myModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });

        });

        function populateModal(goatData) {
            const modalHeader = $('#myModalHeader');
            const modalBody = $('#myModalBody');

            // Clear previous content
            modalHeader.empty();
            modalBody.empty();

            modalHeader.append('<h5 class="modal-title">Goat Information</h5>');
            // Add Goat Card
            if (goatData) {
                const cardHeader = '<div class="card-header form-control-lg">' +
                    (goatData.is_active === 1 ? 'Goat' : (goatData.sale_date ? 'Goat Sold <i class="fas fa-hand-holding-usd ml-3" style="font-size: 8mm;"></i>'  : (goatData.date_of_death ? 'Goat Dead <i style="font-size: 8mm;" class="fas fa-skull-crossbones ml-3"></i>' : 'Goat'))) +
                    '</div>';

                modalBody.append('<div class="card">'+cardHeader+'<div class="card-body">' +
                    '<div class="row">' +
                    '<div class="col-12 col-md-6 col-lg-4">' +
                    '<p><strong>Is Active:</strong> ' + (goatData.is_active === 1 ? '<span class="badge badge-success mb-1 ml-3">Yes</span>' : '<span class="badge badge-danger mb-1 ml-3">No</span>') + '</p>' +
                    (goatData.image ? '<div class="pt-2"><img src="{{ asset("/images") }}/' + goatData.image + '" alt="Goat Image"  width="200"></div>' : '') +
                    '</div>' +
                    '<div class="col-12 col-md-6 col-lg-4">' +
                    '<p><strong>Name:</strong> ' + goatData.name + '</p>' +
                    '<p><strong>Date of Birth:</strong> ' + new Date(goatData.date_of_birth).toLocaleDateString('en-GB').replace(/\//g, '-') + '</p>' +
                    (goatData.breed ? '<p><strong>Breed:</strong> ' + goatData.breed + '</p>' : '') +
                    (goatData.purchase_date ? '<p><strong>Purchase Date:</strong> ' + new Date(goatData.purchase_date).toLocaleDateString('en-GB').replace(/\//g, '-') + '</p>' : '') +
                    '</div>' +
                    '<div class="col-12 col-md-6 col-lg-4">' +
                    '<p><strong>Gender:</strong> ' + goatData.gender + '</p>' +
                    '<p><strong>Age:</strong> ' + goatData.age + '</p>' +
                    (goatData.sale_date ? '<p><strong>Sale Date:</strong> ' + new Date(goatData.sale_date).toLocaleDateString('en-GB').replace(/\//g, '-') + '</p>' : '') +
                    (goatData.date_of_death ? '<p><strong>Date of Death:</strong> ' + new Date(goatData.date_of_death).toLocaleDateString('en-GB').replace(/\//g, '-') + '</p>' : '') +
                    (goatData.gender === 'male' ? '<p><strong>Castrated:</strong> ' + (goatData.is_castrated ? 'Yes' : 'No') + '</p>' : '') +
                    '</div>' +
                    '</div>' +
                    '</div></div>');
            }

            // Add Mother and Father (if available)
            if (goatData.mother || goatData.father) {
                modalBody.append('<div class="card"><div class="card-header form-control-lg">Parents</div><div class="card-body mb-5">' +
                    '<div class="row">' +
                    (goatData.mother ?
                        '<div class="col-md-6 pl-5">' +
                        '<p><strong>Mother:</strong> ' + goatData.mother.name + '</p>' +
                        (goatData.mother.image ?
                            '<div class="pt-2 " style=" height:65%; object-fit: cover;"><img src="{{ asset("/images") }}/' + goatData.mother.image + '" alt="Mother Image" width="100"></div>' : '') +
                        '<a href="#" class="btn btn-primary mt-2 view-goat" data-id='+goatData.mother.id+'>View Mother</a>' +
                        '</div>' : '') +
                    (goatData.father ?
                        '<div class="col-md-6 pl-5">' +
                        '<p><strong>Father:</strong> ' + goatData.father.name + '</p>' +
                        (goatData.father.image ?
                            '<div class="pt-2" style="height: 65%; object-fit: cover;"><img src="{{ asset("/images") }}/' + goatData.father.image + '" alt="Father Image" width="100"></div>' : '') +
                        '<a href="#" class="btn btn-primary mt-2 view-goat" data-id='+goatData.father.id+'>View Father</a>' +
                        '</div>' : '') +
                    '</div>' +
                    '</div></div>');
            }


            // Add Child Goats (if available)
            if (goatData.children && goatData.children.length > 0) {
                modalBody.append('<div class="card"><div class="card-header form-control-lg">Child Goats ('+goatData.children.length+')</div><div class="card-body">' +
                    // Add table structure for child goats
                    '<table class="table table-striped">' +
                    '<thead><tr><th>Name</th><th>Gender</th><th style="text-wrap: nowrap;">Date of Birth</th><th>Is Active</th><th>LifeSpan</th><th>View</th></tr></thead>' +
                    '<tbody>' +
                    goatData.children.map(child => {
                        let status = '';

                        if (child.is_active === 1) {
                            status = '<span class="badge badge-success">Yes</span>';
                        } else if (child.sale_date !== null) {
                            status = '<span class="badge badge-danger">Sold</span>';
                        } else if (child.date_of_death !== null) {
                            status = '<span class="badge badge-danger">Dead</span>';
                        }

                        return '<tr>' +
                            '<td>' + child.name + '</td>' +
                            '<td>' + child.gender + '</td>' +
                            '<td>' + new Date(child.date_of_birth).toLocaleDateString('en-GB').replace(/\//g, '-') + '</td>' +
                            '<td>' + status + '</td>' +
                            '<td>' + child.age + '</td>' +
                            '<td>' +  '<a href="#" class="btn btn-primary mt-2 view-goat" data-id='+child.id+'>View</a>' + '</td>' +
                            '</tr>';
                    }).join('') +
                    '</tbody>' +
                    '</table>' +
                    '</div></div>');
            }


            // Add Goat Reports Card (if available)
            if (goatData.reports && goatData.reports.length > 0) {
                modalBody.append('<div class="card"><div class="card-header form-control-lg">Goat Reports</div><div class="card-body">' +
                    '<div class="list-group">');

                goatData.reports.forEach(report => {

                    modalBody.append('<div class="list-group-item">' +
                        '<div class="row">' +
                        '<div class="col-md-4">' +
                        (report.image ?
                            '<img src="{{ asset("/images") }}/' + report.image + '" alt="Report Image" class="img-fluid" width="100">' :
                            '<div class="no-image-placeholder">No Image Available</div>') +
                        '</div>' +
                        '<div class="col-md-8">' +
                        '<h5 class="mb-3">' + report.title + '</h5>' +
                        '<p class="mb-1"><strong>Date:</strong> ' + new Date(report.report_date).toJSON().slice(0,10).split('-').reverse().join('-') + '</p>' +
                        '<p class="mb-1"><strong>Content:</strong> ' + report.content + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>');
                });

                modalBody.append('</div></div></div>');
            }

// Add Goat Transactions Card (if available)
            if (goatData.transactions && goatData.transactions.length > 0) {
                modalBody.append('<div class="card mt-3"><div class="card-header form-control-lg">Goat Transactions</div><div class="card-body">' +
                    // Add table structure for transactions
                    '<table class="table table-striped">' +
                    '<thead><tr><th>Date</th><th>Type</th><th>Amount</th><th>Description</th></tr></thead>' +
                    '<tbody>' +
                    goatData.transactions.map(transaction => {
                        const isSale = transaction.type === 'sale';
                        const amountClass = isSale ? 'text-success' : 'text-danger';

                        return '<tr>' +
                            '<td>' + new Date(transaction.transaction_date).toLocaleDateString('en-GB').replace(/\//g, '-') + '</td>' +
                            '<td>' + transaction.type + '</td>' +
                            '<td class="' + amountClass + '">' + transaction.amount + '</td>' +
                            '<td>' + transaction.description + '</td>' +
                            '</tr>';
                    }).join('') +
                    '</tbody>' +
                    '</table>' +
                    '</div></div>');
            }

        }


    </script>
@endsection
