@extends('layouts.admin')

@section('title', 'Revenue')

@section('content')
    <div class="box bg-white">
        <div class="table-responsive">
            <hr>
            <div class="row col-md-12">
                <div class="col-md-12">
                    <div class="container">
                        <form method="get" action="{{ route('admin.revenue') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="time_from">From:</label>
                                        <input type="date" name="time_from" id="time_from" class="form-control" value="{{ $timeFrom }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="time_to">To:</label>
                                        <input type="date" name="time_to" id="time_to" class="form-control" value="{{ $timeTo }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="time_frame">Revenue of:</label>
                                        <select name="time_frame" id="time_frame" class="form-control" onchange="this.form.submit()">
                                            <option value="day" {{ $timeFrame == 'day' ? 'selected' : '' }}>day</option>
                                            <option value="week" {{ $timeFrame == 'week' ? 'selected' : '' }}>week</option>
                                            <option value="month" {{ $timeFrame == 'month' ? 'selected' : '' }}>month</option>
                                            <option value="quarter" {{ $timeFrame == 'quarter' ? 'selected' : '' }}>quarter</option>
                                            <option value="year" {{ $timeFrame == 'year' ? 'selected' : '' }}>year</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        <div class="box-body">
            <canvas id="revenueChart" width="600" height="200"></canvas>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenues),
                    borderColor: 'rgb(51, 204, 204)',
                    backgroundColor: 'rgb(255, 255, 255)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                animation: false,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 17
                            }
                        }
                    },
                }
            }
        });
    </script>
@stop
