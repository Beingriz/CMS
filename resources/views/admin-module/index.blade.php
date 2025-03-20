@extends('admin-module.admin_master')
<title>Dashboard</title>

@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row mb-3">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h4>
                <div>
                    <a href="{{ route('new.application') }}" class="btn btn-sm btn-primary">New Application</a>
                    <a href="{{ route('Credit') }}" class="btn btn-sm btn-success">Credit</a>
                    <a href="{{ route('Debit') }}" class="btn btn-sm btn-danger">Debit</a>
                </div>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('update.dashboard', 'Enquiry') }}" class="dashboard-card">
                    <div class="card shadow-lg border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Enquiry Leads</h6>
                                <h3 class="text-dark">{{ $totalEnquiries }}</h3>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> 9.23% from last period</small>
                            </div>
                            <i class="fas fa-chart-line text-primary fa-3x"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('update.dashboard', 'Orders') }}" class="dashboard-card">
                    <div class="card shadow-lg border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">New Orders</h6>
                                <h3 class="text-dark">{{ $totalOrders }}</h3>
                                <small class="text-danger"><i class="fas fa-arrow-down"></i> 1.09% from last period</small>
                            </div>
                            <i class="fas fa-shopping-cart text-danger fa-3x"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('update.dashboard', 'User') }}" class="dashboard-card">
                    <div class="card shadow-lg border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">New Users</h6>
                                <h3 class="text-dark">{{ $newUsers }}</h3>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> 16.2% from last period</small>
                            </div>
                            <i class="fas fa-users text-info fa-3x"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('update.dashboard', 'Callback') }}" class="dashboard-card">
                    <div class="card shadow-lg border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Call Back</h6>
                                <h3 class="text-dark">{{ $callBack }}</h3>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> 11.7% from last period</small>
                            </div>
                            <i class="fas fa-phone text-success fa-3x"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div> <!-- End Row -->

        <!-- Admin Livewire Dashboard -->
        @livewire('admin-module.dashboard.dashboard-insight')

    </div> <!-- End Container -->
</div>
@endsection

<!-- Loading Overlay -->
<div id="loading-overlay" class="loading-overlay d-none">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<!-- Scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        showLoading(); // Show overlay
        setTimeout(() => {
            hideLoading(); // Hide overlay after 1 sec
            @if(session('swal'))
                Swal.fire({
                    title: "{{ session('swal.title') }}",
                    text: "{{ session('swal.text') }}",
                    icon: "{{ session('swal.icon') }}",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif
        }, 1000);
    });

    function showLoading() {
        document.getElementById("loading-overlay").classList.remove("d-none");
    }

    function hideLoading() {
        document.getElementById("loading-overlay").classList.add("d-none");
    }
</script>


<style>
    /* AdminLTE Card Style */
    .dashboard-card {
        text-decoration: none;
    }

    .dashboard-card .card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-left: 5px solid transparent;
    }

    .dashboard-card .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
window.addEventListener("load", function () {

    // Shared Chart Options (to keep styling consistent)
    const chartColors = ["#556ee6", "#34c38f", "#f1b44c"];
    const gradientColors = ["#657ee4", "#39d180", "#f5c06a"];

    // Revenue Chart
    var revenueOptions = {
        chart: { type: "line", height: 250 },
        series: [{
            name: "Revenue",
            data: [
                <?php echo e($lastMonthAmount ?? 0); ?>,
                <?php echo e(is_array($lastWeekAmount) && isset($lastWeekAmount[0]->lastWeekamount) ? $lastWeekAmount[0]->lastWeekamount : 0); ?>,
                <?php echo e($totalRevenue ?? 0); ?>
            ]
        }],
        xaxis: { categories: ["Last Month", "Last Week", "This Month"] },
        colors: ["#008FFB"], // Adjust to match the design
        stroke: { curve: "smooth", width: 3 },
        markers: { size: 4, colors: ["#008FFB"], strokeWidth: 2 }
    };
    new ApexCharts(document.querySelector("#revenue-chart"), revenueOptions).render();

    // Service Applications Chart
    var serviceOptions = {
        chart: { type: "bar", height: 280, toolbar: { show: false } },
        series: [{
            name: "Applications",
            data: [<?php echo e($officeApp ?? 0); ?>, <?php echo e($directApp ?? 0); ?>, <?php echo e($callBackApp ?? 0); ?>]
        }],
        xaxis: {
            categories: ["Office", "Direct Apply", "Call Back"],
            labels: { style: { colors: chartColors, fontSize: '14px' } }
        },
        colors: chartColors,
        plotOptions: {
            bar: {
                borderRadius: 6,
                horizontal: false,
                columnWidth: "55%",
                endingShape: "rounded"
            }
        },
        dataLabels: { enabled: false },
        fill: {
            type: "gradient",
            gradient: { shade: "light", type: "vertical", gradientToColors: gradientColors, stops: [0, 100] }
        }
    };
    new ApexCharts(document.querySelector("#serviceChart"), serviceOptions).render();
});
</script>
