<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    {{-- <!-- App favicon --> {{asset('backend/')}} --}}

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    @livewireStyles
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    {{-- My old Website CSS  --}}
    <link href="{{ asset('Bootstrap/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('Bootstrap/css/600.css') }}" rel="stylesheet">

<title>Professional Bill</title>
<style type="text/css">
    @page {
        size: A4;
        margin: 15mm; /* Set margins to ensure content fits within the page */
    }
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        background-color: #f4f4f4;
    }
    .container {
        width: 90%;
        max-width: 190mm; /* Ensure the container width fits within the A4 margins */
        margin: 0 auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        padding: 10mm;
        box-sizing: border-box;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .header img {
        max-width: 120px;
        height: auto;
    }
    .header h1 {
        font-size: 24px;
        color: #007bff;
    }
    .header p {
        font-size: 14px;
        color: #555;
        margin: 0;
    }
    .details {
        margin-bottom: 20px;
        font-size: 14px;
        color: #555;
    }
    .details strong {
        color: #333;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    table th, table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 12px;
    }
    table th {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }
    table td {
        background-color: #f9f9f9;
    }
    table tfoot td {
        font-weight: bold;
    }
    .footer {
        font-size: 12px;
        color: #555;
        text-align: center;
        margin-top: 20px;
    }
</style>
</head>
<body>

    <div class="invoice-2 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner clearfix">
                        <div class="invoice-info clearfix" id="invoice_wrapper">
                            <div class="invoice-headar">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="invoice-logo">
                                            <!-- logo started -->
                                            <div class="logo">
                                                <img src="assets/img/logos/logo.png" alt="logo">
                                            </div>
                                            <!-- logo ended -->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice-id">
                                            <div class="info">
                                                <h1 class="inv-header-1">Invoice</h1>
                                                <p class="mb-1">Invoice Number: <span>#45613</span></p>
                                                <p class="mb-0">Invoice Date: <span>24 Jan 2022</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="invoice-number mb-30">
                                            <h4 class="inv-title-1">Invoice To</h4>
                                            <h2 class="name">Jhon Smith</h2>
                                            <p class="invo-addr-1">
                                                Theme Vessel <br>
                                                info@themevessel.com <br>
                                                21-12 Green Street, Meherpur, Bangladesh <br>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice-number mb-30">
                                            <div class="invoice-number-inner">
                                                <h4 class="inv-title-1">Invoice From</h4>
                                                <h2 class="name">Animas Roky</h2>
                                                <p class="invo-addr-1">
                                                    Apexo Inc  <br>
                                                    billing@apexo.com <br>
                                                    169 Teroghoria, Bangladesh <br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-center">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-striped invoice-table">
                                        <thead class="bg-active">
                                        <tr class="tr">
                                            <th>No.</th>
                                            <th class="pl0 text-start">Item Description</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="tr">
                                            <td>
                                                <div class="item-desc-1">
                                                    <span>01</span>
                                                </div>
                                            </td>
                                            <td class="pl0">Businesscard Design</td>
                                            <td class="text-center">$300</td>
                                            <td class="text-center">2</td>
                                            <td class="text-end">$600.00</td>
                                        </tr>
                                        <tr class="bg-grea">
                                            <td>
                                                <div class="item-desc-1">
                                                    <span>02</span>

                                                </div>
                                            </td>
                                            <td class="pl0">Fruit Flayer Design</td>
                                            <td class="text-center">$400</td>
                                            <td class="text-center">1</td>
                                            <td class="text-end">$60.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="item-desc-1">
                                                    <span>03</span>
                                                </div>
                                            </td>
                                            <td class="pl0">Application Interface Design</td>
                                            <td class="text-center">$240</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">$640.00</td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="item-desc-1">
                                                    <span>04</span>
                                                </div>
                                            </td>
                                            <td class="pl0">Theme Development</td>
                                            <td class="text-center">$720</td>
                                            <td class="text-center">4</td>
                                            <td class="text-end">$640.00</td>
                                        </tr>
                                        <tr class="tr2">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center">SubTotal</td>
                                            <td class="text-end">$710.99</td>
                                        </tr>
                                        <tr class="tr2">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center">Tax</td>
                                            <td class="text-end">$85.99</td>
                                        </tr>
                                        <tr class="tr2">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center f-w-600 active-color">Grand Total</td>
                                            <td class="f-w-600 text-end active-color">$795.99</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-bottom">
                                <div class="row">
                                    <div class="col-lg-6 col-md-5 col-sm-5">
                                        <div class="payment-method mb-30">
                                            <h3 class="inv-title-1">Payment Method</h3>
                                            <ul class="payment-method-list-1 text-14">
                                                <li><strong>Account No:</strong> 00 123 647 840</li>
                                                <li><strong>Account Name:</strong> Jhon Doe</li>
                                                <li><strong>Branch Name:</strong> xyz</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-7 col-sm-7">
                                        <div class="terms-conditions mb-30">
                                            <h3 class="inv-title-1">Terms &amp; Conditions</h3>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy has</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-contact clearfix">
                                <div class="row g-0">
                                    <div class="col-sm-12">
                                        <div class="contact-info clearfix">
                                            <a href="tel:+55-4XX-634-7071" class="d-flex"><i class="fa fa-phone"></i> +00 123 647 840</a>
                                            <a href="tel:info@themevessel.com" class="d-flex"><i class="fa fa-envelope"></i> info@themevessel.com</a>
                                            <a href="tel:info@themevessel.com" class="mr-0 d-flex d-none-580"><i class="fa fa-map-marker"></i> 169 Teroghoria, Bangladesh</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-btn-section clearfix d-print-none">
                            <a href="javascript:window.print()" class="btn btn-lg btn-print">
                                <i class="fa fa-print"></i> Print Invoice
                            </a>
                            <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme">
                                <i class="fa fa-download"></i> Download Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
