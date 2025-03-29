@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit Inventory Item</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Hidden Item Code -->
                    <input type="hidden" name="item_code" value="{{ $inventory->item_code }}">

                    <div class="row">
                        <!-- Date Request (Completely Disabled) -->
                        <div class="col-md-6 mb-3">
                            <label for="date_request" class="form-label fw-bold">Date Request</label>
                            <input type="date" class="form-control" value="{{ $inventory->date_request }}" disabled>
                            <input type="hidden" name="date_request" value="{{ $inventory->date_request }}">
                        </div>

                        <!-- Item Description (Completely Disabled) -->
                        <div class="mb-3">
                            <label for="item_description" class="form-label fw-bold">Item Description</label>
                            <textarea class="form-control" rows="2" disabled>{{ $inventory->item_description }}</textarea>
                            <input type="hidden" name="item_description" value="{{ $inventory->item_description }}">
                        </div>

                        <div class="row">
                            <!-- Beginning Inventory (Completely Disabled) -->
                            <div class="col-md-6 mb-3">
                                <label for="beg_inv" class="form-label fw-bold">Beginning Inventory</label>
                                <input type="number" class="form-control" value="{{ $inventory->beg_inv }}" disabled>
                                <input type="hidden" name="beg_inv" value="{{ $inventory->beg_inv }}">
                            </div>

                            <!-- Delivery (Editable) -->
                            <div class="col-md-6 mb-3">
                                <label for="delivery" class="form-label fw-bold">Delivery</label>
                                <input type="number" class="form-control" name="delivery" id="delivery"
                                    value="{{ $inventory->delivery }}">
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="stock_out" value="{{ $inventory->stock_out }}">
                        <input type="hidden" name="end_inv" id="end_inv" value="{{ $inventory->end_inv }}">

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('inventory.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-success">Save Changes</button>
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
                    title: messageType === 'success' ? "Success!" : "Error!",
                    text: message,
                    icon: messageType,
                    confirmButtonText: "OK"
                });
            }
        });

        // Update Ending Inventory Automatically
        document.getElementById("delivery").addEventListener("input", function() {
            let begInv = parseInt("{{ $inventory->beg_inv }}") || 0;
            let delivery = parseInt(this.value) || 0;
            let stockOut = parseInt("{{ $inventory->stock_out }}") || 0;

            document.getElementById("end_inv").value = begInv + delivery - stockOut;
        });
    </script>
@endsection
