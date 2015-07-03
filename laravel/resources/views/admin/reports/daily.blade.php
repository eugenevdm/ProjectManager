@extends('app')

@section('content')
    <h3>Dashboard</h3>

    <label for = "daily-reports">Tasks Created<br />
    <canvas id="daily-reports" width="342" height="300"></canvas>
    </label>

    <label for = "daily-reports">Tasks Updated<br />
    <canvas id="tasks-updated-report" width="342" height="300"></canvas>
    </label>

    <h3>Amount of Tasks Created</h3>
    @foreach ($totals as $index => $dailyAmounts)
        <li><strong>{{ $dates[$index] }}</strong> {{ $dailyAmounts}}</li>
    @endforeach

    <script src="/js/vendor/chart.js"></script>
    <script>
        (function() {
            var ctx = document.getElementById('tasks-updated-report').getContext('2d');
            var chart = {
                labels: {!! json_encode($updatedDates)  !!},
                datasets: [{
                    data: {{ json_encode($updatedTasks) }},
                    fillColor : "#f8b1aa",
                    strokeColor : "#bb574e",
                    pointColor : "#bb574e"
                }]
            };
            new Chart(ctx).Bar(chart, { bezierCurve: false });
        })();

        (function() {
            var ctx = document.getElementById('daily-reports').getContext('2d');
            var chart = {
                labels: {!! json_encode($dates)  !!},
                datasets: [{
            data: {{ json_encode($totals) }},
            fillColor : "#f8b1aa",
            strokeColor : "#bb574e",
            pointColor : "#bb574e"
        }]
        };
        new Chart(ctx).Bar(chart, { bezierCurve: false });
        })();
    </script>
@stop