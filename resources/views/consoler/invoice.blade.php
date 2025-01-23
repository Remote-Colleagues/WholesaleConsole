@extends('consoler.layouts.app')

@section('headerTitle', 'Invoices')

@section('content')

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary" style="pointer-events: none; user-select: none;">List of Invoices</h6>
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
                        @foreach ($consolerInvoices as $invoice)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($invoice->date_created)->format('d M, Y') }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ ucwords(strtolower($invoice->consoler_name)) }}</td>
                                <td>{{ number_format($invoice->amount, 2) }}</td>
                                <td>{{ ucwords(strtolower($invoice->status ?? 'No Status')) }}</td>
                                <td>
                                    <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-info">Download</a>
                                    <button type="button" class="btn btn-info view-invoice-btn" data-invoice-id="{{ $invoice->id }}">View</button>
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
                {{ $consolerInvoices->links('pagination::bootstrap-5') }}
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

@endsection
