@extends('layouts.app')
@if (session('success'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>
@endif
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Stocks</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf

                    <!-- Hidden Item Code -->
                    <input type="hidden" name="item_code" id="item_code" value="{{ old('item_code', 'Generating...') }}">
                    <!-- Item Description -->
                    <div class="mb-3">
                        <label for="item_description" class="form-label fw-bold">Item Description</label>
                        <textarea class="form-control" name="item_description" rows="2" placeholder="Enter item description" required></textarea>
                    </div>

                    <div class="row">
                        <!-- Beginning Inventory -->
                        <div class="col-md-6 mb-3">
                            <label for="beg_inv" class="form-label fw-bold">Beginning Inventory</label>
                            <input type="number" class="form-control" name="beg_inv" required>
                        </div>

                        <!-- Delivery -->
                        <div class="col-md-6 mb-3">
                            <label for="delivery" class="form-label fw-bold">Delivery</label>
                            <input type="number" class="form-control" name="delivery">
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="stock_out" id="stock_out" value="0">
                    <input type="hidden" name="end_inv" id="end_inv" readonly>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('inventory.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-success" id="saveItemBtn">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let message = "{{ session('message') }}";
            let messageType = "{{ session('message_type') }}"; // 'success' or 'warning'

            if (message) {
                Swal.fire({
                    title: messageType === 'success' ? "Success!" : "Deleted!",
                    text: message,
                    icon: messageType,
                    confirmButtonText: "OK"
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('inventory.generateCode') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("item_code").value = "ITEM-" + String(data.item_code).padStart(5,
                        '0');
                });
        });

        document.addEventListener("DOMContentLoaded", function() {
            let begInv = document.getElementById("beginning_inventory");
            let delivery = document.getElementById("delivery");
            let stockOut = document.getElementById("stock_out");
            let endInv = document.getElementById("end_inv");

            function updateEndingInventory() {
                let beg = parseInt(begInv.value) || 0;
                let del = parseInt(delivery.value) || 0;
                let stock = parseInt(stockOut.value) || 0;
                endInv.value = beg + del - stock;
            }

            stockOut.addEventListener("input", updateEndingInventory);
            delivery.addEventListener("input", updateEndingInventory);
        });
    </script>
@endsection
