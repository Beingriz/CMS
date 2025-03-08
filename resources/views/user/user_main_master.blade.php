<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- FontAwesome and Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">

    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
    </style>
</head>

<body>

    <!-- Loading Spinner Overlay -->
    <div id="loading-overlay" wire:loading.class="d-block" wire:loading.class.remove="d-none" class="loading-overlay d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Header Section -->
    @include('user.body.header')

    <!-- Main Content -->
    <main>
        @yield('user')
    </main>

    <!-- Footer Section -->
    @include('user.body.footer')

    <!-- Scripts Section -->

    <!-- jQuery (Load First) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap Wizard -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap-wizard/1.4.2/jquery.bootstrap.wizard.min.js"></script>

    <!-- ApexCharts (For Charts) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- SweetAlert2 (For Alerts) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Custom JS -->
    <script src="{{ asset('backend/assets/js/code.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('closeConsentModal', () => {
                const consentModal = document.getElementById('consentModal');
                const modalInstance = bootstrap.Modal.getInstance(consentModal) || new bootstrap.Modal(consentModal);
                modalInstance.hide();
            });
        });
    </script>


    <script>


        // Initialize DataTables
        $(document).ready(function () {
            $('#your-table-id').DataTable();
        });

        // Initialize Bootstrap Wizard
        $(document).ready(function () {
            $('#yourWizardId').bootstrapWizard();
        });

        // ApexCharts Example (Ensure element exists before rendering)
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('chart')) {
                var options = {
                    series: [44, 55, 41],
                    chart: { type: 'pie' },
                };
                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            }
        });

        // Toastr Notification Logic
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>

</body>

</html>
