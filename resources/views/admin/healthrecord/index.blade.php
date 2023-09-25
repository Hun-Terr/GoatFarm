@extends('layouts.admin')

@section('content')


<div class="section-header">
    <h1>Blank Page</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>All Farm Goats</h4>
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
                                    <th>Breed</th>
                                    <th>Gender</th>
                                    <th width="280px">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>sidd</td>
                                        <td>man</td>
                                        <td>male</td>
                                        <td>
                                            <a class="btn btn-info" href="#">Show</a>
                                            <a class="btn btn-primary" href="#">Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>



</div>

@endsection
