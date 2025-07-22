@extends('layouts.app')

@section('content')
<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Income Report</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Income</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Filter Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <form method="GET" class="row g-3">
                                <div class="col-md-5">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                           value="{{ $startDate->toDateString() }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                           value="{{ $endDate->toDateString() }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Totals Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="mb-3">Income Summary</h4>
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded bg-light">
                                        <h5>Total Income</h5>
                                        <p class="fs-4 fw-bold text-success">${{ number_format($totalIncome, 2) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded bg-light">
                                        <h5>Monthly Subscription</h5>
                                        <p class="fs-4 fw-bold text-info">${{ number_format($monthlyTotal, 2) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded bg-light">
                                        <h5>Yearly Subscription</h5>
                                        <p class="fs-4 fw-bold text-warning">${{ number_format($yearlyTotal, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payments Table -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Payments</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Interval</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allInvoices as $invoice)
                                        <tr>
                                            <td>{{ $invoice['customer'] ?? 'N/A' }}</td>
                                            <td>${{ number_format($invoice['amount'], 2) }}</td>
                                            <td>{{ $invoice['date'] }}</td>
                                            <td>{{ ucfirst($invoice['interval']) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No invoices found for this period.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </div> <!-- /.app-content -->
</main>
@endsection
