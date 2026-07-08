<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
        return [
            'number' => ['required', 'string', 'unique:invoices,number'],
            'supplier_name' => ['required', 'string', 'max:255'],
            'supplier_tax_id' => ['required', 'string', 'max:50'],
            'net_amount' => ['required', 'numeric', 'gt:0'],
            'vat_amount' => ['required', 'numeric', 'gte:0'],
            'currency' => ['required', 'string', 'size:3'],
            'issue_date' => ['required', 'date'],

            'due_date' => [
                'required',
                'date',
                'after_or_equal:issue_date'
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
