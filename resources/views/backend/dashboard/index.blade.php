@extends('backend.template.main')

@section('title', 'Dashboard')

@section('content')
    {{-- content --}}
    <div class="container mt-5">
        <h1>Dashboard</h1>
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Transaksi</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalTransactions }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Total Pending</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalPending }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Total Failed</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalFailed }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Success</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalSuccess }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <h2>Transaksi Terbaru</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($latestTransactions as $transaction)
                    <tr>
                        <td>{{ ($latestTransactions->currentPage() - 1) * $latestTransactions->perPage() + $loop->iteration }}
                        </td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->status }}</td>
                        <td>{{ $transaction->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{-- end content --}}
@endsection
