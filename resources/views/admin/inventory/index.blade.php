@extends('layouts.app')
@section('content')
    @if (session('message'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "{{ session('message_type', 'info') === 'success' ? 'Success!' : 'Deleted!' }}",
                    text: "{{ session('message') }}",
                    icon: "{{ session('message_type', 'info') }}",
                    confirmButtonText: "OK"
                });
            });
        </script>
    @endif

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
            .table thead {
                background-color: #ffc107;
                text-align: center;
                font-weight: bold;
            }

            .table tbody td {
                text-align: center;
                vertical-align: middle;
            }

            .summary {
                background-color: #ff5733;
                color: white;
                font-weight: bold;
            }

            #deleteAllBtn {
                margin-left: auto;
                /* Pushes the button to the right */
                display: block;
                /* Ensures it behaves as a block element */
            }

            .btn-group .btn {
                background: transparent;
                color: #333;
                font-weight: 500;
                padding: 6px 12px;
                border: none;
                transition: all 0.3s ease-in-out;
            }

            /* View Button */
            .btn-view {
                color: #0d6efd;
            }

            .btn-view:hover {
                background: rgba(13, 110, 253, 0.1);
                color: #0d6efd;
            }

            /* Edit Button */
            .btn-edit {
                color: #0dcaf0;
            }

            .btn-edit:hover {
                background: rgba(13, 202, 240, 0.1);
                color: #0dcaf0;
            }

            /* Delete Button */
            .btn-delete {
                color: #dc3545;
            }

            .btn-delete:hover {
                background: rgba(220, 53, 69, 0.1);
                color: #dc3545;
            }
        </style>
    </head>
    <div class="container">
        <h2 class="mb-3">Stocks Management</h2>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(button) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest("form").submit(); // Submit the form
                    }
                });
            }
            document.getElementById('deleteAllBtn').addEventListener('click', function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete all inventory records!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete all!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('deleteAllForm').submit();
                    }
                });
            });

            // Show success alert if deletion was successful
            @if (session('success'))
                Swal.fire({
                    title: "Deleted!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            @endif
        </script>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Item Code</th>
                        <th rowspan="2">Item Description</th>
                        <th rowspan="2">Beginning Inventory</th>
                        <th rowspan="2">Delivery</th>
                        <th colspan="2">Stock Out</th>
                        <th rowspan="2">Ending Inventory</th>
                        <th rowspan="2" class="text-center align-middle">Actions</th> <!-- Centered Actions Header -->
                    </tr>
                    <tr>
                        <th>SLI</th>
                        <th>SLR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->item_code }}</td>
                            <td>{{ $item->item_description }}</td>
                            <td>{{ $item->beg_inv }}</td>
                            <td>{{ $item->delivery }}</td>
                            <td>{{ $item->stock_out_sli }}</td>
                            <td>{{ $item->stock_out_slr }}</td>
                            <td>{{ $item->end_inv }}</td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <!-- View Button -->
                                    <a href="{{ route('inventory.show', $item) }}" class="btn btn-sm btn-view">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('inventory.edit', $item) }}" class="btn btn-sm btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('inventory.destroy', $item) }}" method="POST"
                                        class="delete-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-delete" onclick="confirmDelete(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5"><strong>Total Stock Out</strong></td>
                        <td>{{ $total_sli }}</td>
                        <td>{{ $total_slr }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
@endsection
