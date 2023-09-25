@extends('layouts.admin')
@section('css')

@endsection

@section('content')


    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-start mb-3">
                    <a href="{{route('goat.add')}}" class="btn btn-lg btn-primary mr-2"><i class="fas fa-horse"></i>  Add Goat</a>
                    <a href="{{route('report.add')}}" class="btn btn-lg btn-secondary mr-2 ml-4"><i class="fas fa-file-invoice"></i>  Add Report</a>
                    <a href="{{route('transaction.add')}}" class="btn btn-lg btn-success ml-4"><i class="fas fa-rupee-sign"></i>  Add Transaction</a>
                </div>
            </div>
        </div>


        <div class="row mt-4">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Goat Statistics</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-warehouse"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total Goats</h4>
                                        </div>
                                        <div class="card-body">
                                            {{$data->total_goats}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Active Goats</h4>
                                        </div>
                                        <div class="card-body">
                                            {{$data->active_goats}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-danger">
                                        <i class="fas fa-skull-crossbones"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Dead Goats</h4>
                                        </div>
                                        <div class="card-body">
                                            {{$data->dead_goats}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-warning">
                                        <i class="fas fa-horse"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Sold Goats</h4>
                                        </div>
                                        <div class="card-body">
                                            {{$data->sold_goats}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Age-wise Goat Count by Gender (Chart)</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="ageGenderChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-secondary">
                        <i class="fas fa-male"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Active Male Goats</h4>
                        </div>
                        <div class="card-body">
                            {{$data->active_male_goats}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-female"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Active Female Goats</h4>
                        </div>
                        <div class="card-body">
                            {{$data->active_female_goats}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Expense Distribution</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="expenseChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" style="margin-top: -530px;">
                <div class="card">
                    <div class="card-header">
                        <h4>Financial Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-danger">
                                        <i class="fas fa-coins"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total Investment</h4>
                                        </div>
                                        <div class="card-body">
                                            ₹ {{$data->total_investment}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-success">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total Revenue</h4>
                                        </div>
                                        <div class="card-body">
                                            ₹ {{$data->total_revenue}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Net Profit</h4>
                                        </div>
                                        <div class="card-body">
                                            ₹ {{$data->net_profit}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row mt-4">

        </div>

    </div>
@endsection
@section('js')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Expense data with different colors for each category
        var expenseData = @json($expenseData);

        // Get the canvas element
        var ctx = document.getElementById("expenseChart").getContext("2d");

        // Create the pie chart
        var expenseChart = new Chart(ctx, {
            type: "pie",
            data: expenseData,
            options: {
                legend: {
                    display: true,
                    position: "bottom", // Adjust legend position
                },
            },
        });

    </script>

    <script>
        // Dummy data for goats with age in months and gender
        const goatsData = @json($goatsData);

        // Function to categorize goats by age and gender and update counts
        function categorizeGoatsByAgeAndGender(goats) {
            const categories = ['Age < 8 Months', '8 Months - 4 Years', 'Age > 4 Years'];


            const data = {
                labels: categories,
                datasets: [
                    {
                        label: 'Male',
                        data: [],
                        backgroundColor: '#3498db', // Blue color for male goats
                        borderWidth: 1,
                    },
                    {
                        label: 'Female',
                        data: [],
                        backgroundColor: '#EA64CDFF', // Orange color for female goats
                        borderWidth: 1,
                    },
                ],
            };

            categories.forEach(category => {
                const maleCount = goats.filter(goat => goat.gender === 'male' && calculateAgeCategory(goat.ageMonths) === category).length;
                const femaleCount = goats.filter(goat => goat.gender === 'female' && calculateAgeCategory(goat.ageMonths) === category).length;
                data.datasets[0].data.push(maleCount);
                data.datasets[1].data.push(femaleCount);
            });

            // Create an inverted grouped bar chart
            const ctx = document.getElementById('ageGenderChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        x: {
                            beginAtZero: true,
                        },
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        }

        // Helper function to calculate age category
        function calculateAgeCategory(ageMonths) {
            if (ageMonths < 8) {
                return 'Age < 8 Months';
            } else if (ageMonths >= 8 && ageMonths <= 48) {
                return '8 Months - 4 Years';
            } else {
                return 'Age > 4 Years';
            }
        }

        // Call the function with your actual goat data
        categorizeGoatsByAgeAndGender(goatsData);
    </script>

@endsection
