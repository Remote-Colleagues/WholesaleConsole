<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination;
class InvoiceController extends Controller
{

    public function index()
    {
        $id = auth()->id();
        $invoices = Invoice::with('consoler')->get();
        return view('admin.invoice', compact('invoices'));
    }

    public function updateInvoiceStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $request->validate([
            'status' => 'required|in:paid,pending,hide',
        ]);
        $invoice->status = $request->status;
        $invoice->save();
        return redirect()->route('invoices.index')->with('success', 'Invoice status updated successfully.');
    }
    public function generatePDF($id)
    {
        $invoice = Invoice::with('consoler', 'consoler.user')->findOrFail($id);
        $admin = Admin::first();
        $address = implode(', ', array_filter([
            $invoice->consoler->building,
            $invoice->consoler->city,
            $invoice->consoler->state,
            $invoice->consoler->country,
            $invoice->consoler->post_code
        ])) ?? 'N/A';
        $data = [
            'invoice' => $invoice,
            'address' => $address ?? 'N/A',
            'abn_number' => $invoice->consoler->abn_number ?? 'N/A',
            'contactEmail' => $invoice->consoler->user->email ?? 'N/A',
            'contactPhone' => $invoice->consoler->contact_number ?? 'N/A',
            'bsb' => $admin->bsb_number ?? 'N/A',
            'accountNumber' => $admin->banking_detail ?? 'N/A',
            'accountHolder' => $admin->name ?? 'N/A',
            'establishmentFee' => $invoice->consoler->establishment_fee ?? 0,
            'subscriptionFee' => $invoice->consoler->monthly_subscription_fee ?? 0,
            'totalAmount' => $invoice->amount,
            'email' => $admin->user->email ?? 'N/A',
            'Phone' => $admin->contact_phone_number ?? 'N/A',
        ];

        $pdf = Pdf::loadView('admin.invoicepdf', $data);
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }



    public function getInvoiceContent($id)
    {
        $invoice = Invoice::with('consoler', 'consoler.user')->findOrFail($id);
        $admin = Admin::first();
        $address = implode(', ', array_filter([
            $invoice->consoler->building,
            $invoice->consoler->city,
            $invoice->consoler->state,
            $invoice->consoler->country,
            $invoice->consoler->post_code
        ])) ?? 'N/A';
        $data = [
            'invoice' => $invoice,
            'abn_number' => $admin->abn_number ?? 'N/A',
            'abn' => $invoice->consoler->abn_number ?? 'N/A',
            'contactEmail' => $invoice->consoler->user->email ?? 'N/A',
            'contactPhone' => $invoice->consoler->contact_person ?? 'N/A',
            'address' => $address ?? 'N/A',
            'bsb' => $admin->bsb_number ?? 'N/A',
            'email' => $admin->user->email ?? 'N/A',
            'Phone' => $admin->contact_phone_number ?? 'N/A',
            'accountNumber' => $admin->banking_detail ?? 'N/A',
            'accountHolder' => $admin->name ?? 'N/A',
            'establishmentFee' => $invoice->consoler->establishment_fee ?? 0,
            'subscriptionFee' => $invoice->consoler->monthly_subscription_fee ?? 0,
            'totalAmount' => $invoice->amount,
        ];

        return view('admin.invoicepdf', $data)->render();
    }
    public function partnerPDF($id)
    {
        $invoice = Invoice::with('partner', 'partner.user')->findOrFail($id);
        $admin = Admin::first();
        $data = [
            'invoice' => $invoice,
            'address' => $invoice->partner->operation_location ?? 'N/A',
            'abn_number' => $invoice->partner->abn_number ?? 'N/A',
            'contactEmail' => $invoice->partner->user->email ?? 'N/A',
            'contactPhone' => $invoice->partner->contact_number ?? 'N/A',
            'bsb' => $admin->bsb_number ?? 'N/A',
            'accountNumber' => $admin->banking_detail ?? 'N/A',
            'accountHolder' => $admin->name ?? 'N/A',
            'establishmentFee' => $invoice->partner->establishment_fee ?? 0,
            'subscriptionFee' => $invoice->partner->monthly_subscription_fee ?? 0,
            'totalAmount' => $invoice->amount,
            'email' => $admin->user->email ?? 'N/A',
            'Phone' => $admin->contact_phone_number ?? 'N/A',
        ];

        $pdf = Pdf::loadView('partner.invoicepdf', $data);
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }



    public function partnerinvoice($id)
    {
        $invoice = Invoice::with('partner', 'partner.user')->findOrFail($id);
        $admin = Admin::first();
        $data = [
            'invoice' => $invoice,
            'abn_number' => $admin->abn_number ?? 'N/A',
            'abn' => $invoice->partner->abn_number ?? 'N/A',
            'contactEmail' => $invoice->partner->user->email ?? 'N/A',
            'contactPhone' => $invoice->partner->contact_person ?? 'N/A',
            'address' => $invoice->partner->operation_location ?? 'N/A',
            'bsb' => $admin->bsb_number ?? 'N/A',
            'email' => $admin->user->email ?? 'N/A',
            'Phone' => $admin->contact_phone_number ?? 'N/A',
            'accountNumber' => $admin->banking_detail ?? 'N/A',
            'accountHolder' => $admin->name ?? 'N/A',
            'establishmentFee' => $invoice->partner->establishment_fee ?? 0,
            'subscriptionFee' => $invoice->partner->monthly_subscription_fee ?? 0,
            'totalAmount' => $invoice->amount,
        ];

        return view('admin.invoicepdf', $data)->render();
    }

    public function filter(Request $request)
    {
        $consolerNames =Invoice::distinct()->pluck('consoler_name');
        $invoices = Invoice::when($request->filter_consoler, function ($query) use ($request) {
            $query->where('consoler_name', 'like', '%' . $request->filter_consoler . '%');
        })->paginate(10);
        return view('admin.invoice', compact('invoices','consolerNames'));
    }



}
