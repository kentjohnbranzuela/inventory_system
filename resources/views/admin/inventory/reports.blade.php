@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <div class="container">
        <h2>Inventory Reports</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date Request</th>
                    <th>Item Code</th>
                    <th>Item Description</th>
                    <th>Beginning Inventory</th>
                    <th>Delivery</th>
                    <th>Stock Out</th>
                    <th>Ending Inventory</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventory as $item)
                    <tr>
                        <td>{{ $item->date_request }}</td>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->item_description }}</td>
                        <td>{{ $item->beginning_inventory }}</td>
                        <td>{{ $item->delivery }}</td>
                        <td>{{ $item->stock_out }}</td>
                        <td>{{ $item->ending_inventory }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('inventory.reports.export') }}" class="btn btn-success">Download Excel</a>
    </div>
@endsection
