<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::all([
            'item_code',
            'item_description',
            'beg_inv',
            'delivery',
            'stock_out',
            'end_inv'
        ]);
    }

    /**
     * Define the headings for the Excel export.
     */
    public function headings(): array
    {
        return [
            'ITEM CODE',
            'ITEM DESCRIPTION',
            'BEG. INV',
            'DELIVERY',
            'STOCK OUT',
            'END. INV'
        ];
    }
}
