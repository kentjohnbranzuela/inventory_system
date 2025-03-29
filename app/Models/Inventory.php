<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_request', 'item_code', 'item_description',
        'beg_inv', 'delivery', 'stock_out', 'end_inv', 'summary'
    ];

    protected $casts = [
        'summary' => 'array',
    ];

    // Auto-generate Item Code & Calculate Stock
    public static function boot()
    {
        parent::boot();

        static::creating(function ($inventory) {
            // Generate Item Code
            $inventory->item_code = '' . str_pad(self::getNextItemNumber(), 7, '0', STR_PAD_LEFT);

            // Auto-calculate stock out & ending inventory
            $inventory->stock_out = 0; // Default stock out is 0 on creation
            $inventory->end_inv = $inventory->beg_inv + $inventory->delivery; // Initial Ending Inventory
        });

        static::updating(function ($inventory) {
            // Auto-update Ending Inventory when Stock Out changes
            $inventory->end_inv = $inventory->beg_inv + $inventory->delivery - $inventory->stock_out;
        });
    }

    // Get the next Item Number
    private static function getNextItemNumber()
    {
        $latest = self::latest('id')->lockForUpdate()->first();
        return $latest ? $latest->id + 1 : 1;
    }
}
