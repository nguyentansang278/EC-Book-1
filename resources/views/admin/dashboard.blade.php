@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row pt-4">
        <!-- Visitors Section -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $visitorsData['totalCurrentWeek'] }}</h3>
                    <p>Visitors Over Time</p>
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Sales Section -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 id="totalSale">${{ $salesData['totalSaleThisWeek'] }}</h3>
                    <p>Sales of this week</p>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const visitorsCtx = document.getElementById('visitorsChart').getContext('2d');
    const visitorsChart = new Chart(visitorsCtx, {
        type: 'line',
        data: {
            labels: @json($visitorsData['labels']),
            datasets: [
                {
                    label: 'This Week',
                    data: @json($visitorsData['currentWeek']),
                    borderColor: 'RGB(0, 137, 255)',
                    fill: true
                },
                {
                    label: 'Last Week',
                    data: @json($visitorsData['lastWeek']),
                    borderColor: 'gray',
                    fill: true
                }
            ]
        },
    });

    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: @json($salesData['labels']),
            datasets: [
                {
                    label: 'This Week',
                    data: @json($salesData['thisWeek']),
                    backgroundColor: 'RGB(0, 137, 255)'
                },
                {
                    label: 'Last Week',
                    data: @json($salesData['lastWeek']),
                    backgroundColor: 'gray'
                }
            ]
        },
    });

    $(document).ready(function() {
        var $sale = $('#totalSale');
        var totalSale = parseFloat($sale.text().replace(/\$/g, ''));
        $sale.text('$0.00');

        $({ countNum: 0 }).animate({ countNum: totalSale }, {
            duration: 2000,
            easing: 'swing',
            step: function() {
                $sale.text('$' + this.countNum.toFixed(2));
            },
            complete: function() {
                $sale.text('$' + this.countNum.toFixed(2));
            }
        });
    });
</script>
@endsection
