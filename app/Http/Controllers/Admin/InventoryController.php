<?php

namespace App\Http\Controllers\Admin;
use App\Models\Inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\InventoryExport;
use Maatwebsite\Excel\Facades\Excel;


class InventoryController extends Controller
{
    public function export()
{
    return Excel::download(new InventoryExport, 'inventory_report.xlsx');
}
    public function reports()
{
    $inventory = Inventory::all();
    return view('admin.inventory.reports', compact('inventory'));
}
 public function destroyAll(Request $request)
{
    Log::info('DestroyAll method triggered');

    Inventory::truncate(); // Deletes all inventory records

    // Use the same session key for consistency
return redirect()->route('inventory.index')
    ->with('message', 'All inventory records deleted successfully!')
    ->with('message_type', 'warning');}
public function show(Inventory $inventory)
{
    return view('admin.inventory.show', compact('inventory'));
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Inventory::all();
        // Calculate totals for SLI and SLR stock out
    $total_sli = $items->sum('sli_stock_out');
    $total_slr = $items->sum('slr_stock_out');

 return view('admin.inventory.index', compact('items', 'total_sli', 'total_slr'));    }

    public function create()
    {
        return view('admin.inventory.create');
    }

public function store(Request $request)
{
    $inventory = new Inventory();
    $inventory->item_code = $request->item_code;
    $inventory->date_request = $request->date_request;
    $inventory->item_description = $request->item_description;
    $inventory->beg_inv = $request->beg_inv;
    $inventory->delivery = $request->delivery ?? 0;
    $inventory->stock_out = $request->stock_out ?? 0;
    $inventory->end_inv = ($request->beg_inv + $inventory->delivery) - $inventory->stock_out;
    $inventory->save();

    // ✅ SET FLASH MESSAGE PROPERLY
return redirect()->route('inventory.index')
    ->with('message', 'Inventory added successfully!')
    ->with('message_type', 'success');
}
    public function edit(Inventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'item_description' => 'required|string',
            'beg_inv' => 'required|integer|min:0',
            'delivery' => 'required|integer|min:0',
            'stock_out' => 'required|integer|min:0',
            'end_inv' => 'required|integer|min:0',
            'summary' => 'nullable|string',
        ]);

        $inventory->update($request->all());

return redirect()->route('inventory.index')
    ->with('message', 'Item updated successfully!')
    ->with('message_type', 'success');
    }


    public function destroy($id)
{
    $item = Inventory::find($id); // Find item by ID
    if (!$item) {
        return redirect()->route('inventory.index')->with('message', 'Item not found')->with('message_type', 'warning');
    }

    $item->delete(); // Delete the item

    return redirect()->route('inventory.index')->with('message', 'Item deleted successfully')->with('message_type', 'success');
}

}
