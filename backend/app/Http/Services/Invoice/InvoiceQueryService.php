<?php

namespace App\Http\Services\Invoice;

use App\Models\Invoice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InvoiceQueryService
{
    public function getAllInvoices(int $perPage = 15): LengthAwarePaginator
    {
        return Invoice::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getInvoiceById(string $id): Invoice
    {
        return Invoice::findOrFail($id);
    }
}
