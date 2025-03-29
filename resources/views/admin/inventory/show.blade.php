@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div class="container">
        <h2 class="mb-4">Stocks Details</h2>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th width="30%">Item Description</th>
                    <td>{{ $inventory->item_description }}</td>
                </tr>
                <tr>
                    <th>Item Code</th>
                    <td>{{ $inventory->item_code }}</td>
                </tr>
                <tr>
                    <th>Beginning Inventory</th>
                    <td>{{ $inventory->beg_inv }}</td>
                </tr>
                <tr>
                    <th>Stock Out (SLI)</th>
                    <td>{{ $inventory->sli_stock_out }}</td>
                </tr>
                <tr>
                    <th>Stock Out (SLR)</th>
                    <td>{{ $inventory->slr_stock_out }}</td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('inventory.index') }}" class="btn btn-primary">Back to Inventory</a>
    </div>
@endsection
