<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $statuses = ['pending', 'approved', 'rejected'];

        for ($i = 1; $i <= 5; $i++) {
            Invoice::create([
                'id' => (string) Str::uuid(),
                'number' => 'INV-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'supplier_name' => 'Постачальник #' . $i,
                'supplier_tax_id' => 'UA' . rand(10000000, 99999999),
                'net_amount' => 1000.00 * $i,
                'vat_amount' => 200.00 * $i,
                'gross_amount' => 1200.00 * $i,
                'currency' => 'UAH',
                'status' => $statuses[array_rand($statuses)],
                'issue_date' => now()->subDays(10 - $i),
                'due_date' => now()->addDays($i),
            ]);
        }
    }
}
