@extends('layouts.app')

@section('body')
    <div class="container-fluid mt-2 mb-2">
        <!-- Dashboard Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2 class="text-nowrap mb-0">Dashboard</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Edit Post</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dashboard End -->

         <!-- Cards Section -->
  <div class="col d-flex justify-content-between mb-5">
    <div class="card mb-3 dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Number of Users</h5>
            <p class="card-text">{{ $totalUsers }}</p>
        </div>
    </div>
    <div class="card mb-3 dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Number of Admins</h5>
            <p class="card-text">{{ $totalAdmins }}</p>
        </div>
    </div>
    <div class="card mb-3 dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Number of Staffs</h5>
            <p class="card-text">{{ $totalStaffs }}</p>
        </div>
    </div>
    <div class="card mb-3 dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Total Posts</h5>
            <p class="card-text">{{ $totalPosts }}</p>
        </div>
    </div>
    <div class="card mb-3 dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Active Posts</h5>
            <p class="card-text">{{ $activePosts }}</p>
        </div>
    </div>
    <div class="card mb-3 dashboard-card">
        <div class="card-body">
            <h5 class="card-title">Inactive Posts</h5>
            <p class="card-text">{{ $inactivePosts }}</p>
        </div>
    </div>
</div>

        <!-- Chart Section -->
        <div class="row">
            <!-- Pie Chart Section -->
            <div class="col-md-6">
                <div class="card">
                    <div id="piechart" style="width: 100%; height: 500px;"></div>
                </div>
            </div>

            <!-- Bar Chart Section -->
            <div class="col-md-6">
                <div class="card">
                    <div id="barchart" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });

        // Draw the pie chart
        google.charts.setOnLoadCallback(drawPieChart);

        function drawPieChart() {
            var data = google.visualization.arrayToDataTable([
                ['User', 'Posts'],
                @foreach ($postsByUser as $userPost)
                    ['{{ $userPost['user'] }}', {{ $userPost['posts_count'] }}],
                @endforeach
            ]);

            var options = {
                title: 'Posts by User',
                pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }

        // Draw the bar chart
        google.charts.setOnLoadCallback(drawBarChart);

        function drawBarChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Posts', 'Users'],
                @foreach (range(1, 12) as $month)
                    [new Date(0, {{ $month }} - 1).toLocaleString('default', {
                            month: 'short'
                        }),
                        {{ $postsPerMonth->firstWhere('month', $month)->count ?? 0 }},
                        {{ $usersPerMonth->firstWhere('month', $month)->count ?? 0 }}
                    ],
                @endforeach
            ]);

            var options = {
                title: 'Posts and Users per Month',
                hAxis: {
                    title: 'Month'
                },
                vAxis: {
                    title: 'Count'
                },
                seriesType: 'bars',
                series: {
                    1: {
                        type: 'line'
                    }
                }
            };

            var chart = new google.visualization.ComboChart(document.getElementById('barchart'));
            chart.draw(data, options);
        }
    </script>
@endsection
