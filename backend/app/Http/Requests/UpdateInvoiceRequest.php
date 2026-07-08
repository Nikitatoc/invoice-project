<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $invoice = $this->route('invoice');
        if (is_string($invoice)) {
            $invoice = \App\Models\Invoice::find($invoice);
        }

        return [
            'number' => ['sometimes', 'string', 'unique:invoices,number,' . ($invoice?->id ?? '')],
            'supplier_name' => ['sometimes', 'string', 'max:255'],
            'supplier_tax_id' => ['sometimes', 'string', 'max:50'],
            'currency' => ['sometimes', 'string', 'size:3'],
            'issue_date' => ['sometimes', 'date'],

            'net_amount' => ['required', 'numeric', 'gt:0'],
            'vat_amount' => ['required', 'numeric', 'gte:0'],

            'due_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($invoice) {
                    $issueDate = $this->input('issue_date') ?? $invoice?->issue_date;

                    if ($issueDate && tap(new \DateTime($value))->setTime(0,0) < tap(new \DateTime($issueDate))->setTime(0,0)) {
                        $fail('The due date must be a date after or equal to issue date.');
                    }
                }
            ],

            'gross_amount' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $net = (float) $this->input('net_amount');
                    $vat = (float) $this->input('vat_amount');

                    if (abs((float)$value - ($net + $vat)) > 0.01) {
                        $fail('The gross amount must be exactly net_amount + vat_amount.');
                    }
                }
            ],
        ];
    }
}
