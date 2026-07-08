<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'number',
        'supplier_name',
        'supplier_tax_id',
        'net_amount',
        'vat_amount',
        'gross_amount',
        'currency',
        'status',
        'issue_date',
        'due_date',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'net_amount' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'gross_amount' => 'decimal:2',
    ];
}
