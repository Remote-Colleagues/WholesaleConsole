
@extends('admin.layouts.app')

@section('headerTitle', 'Invoices')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold" style="pointer-events: none; user-select: none; color: #5271FF">List of Invoices</h6>
                <form method="GET" action="{{ route('invoices.fill') }}" class="d-flex" id="filterForm">
                    <input type="text" name="filter_consoler" class="form-control form-control-sm" placeholder="Consoler Name" value="{{ request('filter_consoler') }}" id="filterInput">
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                        <thead style="pointer-events: none; user-select: none; color:#5271FF">
                        <tr>
                            <th>Date Created</th>
                            <th>Invoice Number</th>
                            <th>Consoler Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($invoice->date_created)->format('d M, Y') }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ ucwords(strtolower($invoice->consoler_name)) }}</td>
                                <td>{{ number_format($invoice->amount, 2) }}</td>
                                <td>
                                    <form action="{{ route('invoices.updateStatus', $invoice->id) }}" method="POST" id="status-form-{{ $invoice->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="dropdown-wrapper" style="position: relative;">
                                            <select name="status" class="form-control form-control-sm border-2" style="color:#5271FF; border-color: #5271FF;" onchange="submitForm({{ $invoice->id }})">
                                                <option value="" disabled selected>{{ucwords(strtolower($invoice->status ?? 'No Status'))}}</option>
                                                <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="hide" {{ $invoice->status == 'hide' ? 'selected' : '' }}>Hide</option>
                                            </select>
                                            <span class="arrow" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); color: #5271FF;">&#9660;</span>
                                        </div>

                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn border-2" style="color:#5271FF; border-color: #5271FF">Download</a>
                                    <button type="button" class="btn border-2 view-invoice-btn"  style="color:#5271FF; border-color: #5271FF" data-invoice-id="{{ $invoice->id }}">View</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <div class="pagination-container">
{{--                {{ $invoices->links('pagination::bootstrap-5') }}--}}
            </div>
        </div>
    </div>

@endsection
<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice</h5>
                <button type="button" class="btn btn-info" id="printInvoiceButton">Print</button>
            </div>
            <div class="modal-body">
                <!-- Dynamic content will be injected here -->
                <div id="invoiceContent" class="container py-5"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = new bootstrap.Modal(document.getElementById("invoiceModal"));
            const printButton = document.getElementById("printInvoiceButton");
            const closeButton = document.querySelector('[data-bs-dismiss="modal"]');

            // View Invoice Button Logic
            document.querySelectorAll(".view-invoice-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const invoiceId = this.getAttribute("data-invoice-id");
                    fetch(`/invoices/${invoiceId}/content`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById("invoiceContent").innerHTML = html;
                            modal.show();
                        })
                        .catch(error => console.error("Error fetching invoice content:", error));
                });
            });

            // Print Invoice Logic
            printButton.addEventListener("click", () => {
                const invoiceContent = document.getElementById("invoiceContent").innerHTML.trim();
                if (invoiceContent) {
                    const printWindow = window.open("", "_blank");
                    printWindow.document.open();
                    printWindow.document.write(`
                <html>
                <head><title>Invoice</title><style>body { font-family: Arial; margin: 20px; }</style></head>
                <body>${invoiceContent}</body></html>
            `);
                    printWindow.document.close();
                    printWindow.focus();
                    printWindow.onload = () => {
                        printWindow.print();
                        printWindow.close();
                    };
                } else {
                    alert('Invoice content not loaded properly.');
                }
            });

            // Close Modal Logic (this ensures the modal closes correctly)
            closeButton.addEventListener('click', () => modal.hide());
        });

    </script>

    <script>
        function submitForm(invoiceId) {
            document.getElementById('status-form-' + invoiceId).submit();
        }
        document.querySelectorAll('.form-control').forEach(function(selectElement) {
            selectElement.addEventListener('click', function() {
                this.disabled = false;
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const filterInput = document.getElementById("filterInput");
            filterInput.addEventListener("input", () => {
                document.getElementById("filterForm").submit();
            });
        });
    </script>

@endsection
