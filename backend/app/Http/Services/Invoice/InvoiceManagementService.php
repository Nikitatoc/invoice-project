<?php

namespace App\Http\Services\Invoice;

use App\Models\Invoice;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class InvoiceManagementService
{
    public function createInvoice(array $data): Invoice
    {
        $data['status'] = 'pending';
        return Invoice::create($data);
    }

    public function updateInvoice(string $id, array $data): Invoice
    {
        $invoice = Invoice::findOrFail($id);

        if ($invoice->status !== 'pending') {
            throw new UnprocessableEntityHttpException('Only invoices with "pending" status can be updated.');
        }

        $invoice->update($data);
        return $invoice;
    }
}
