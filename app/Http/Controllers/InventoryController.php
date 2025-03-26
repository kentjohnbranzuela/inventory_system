<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InventoryController extends Controller
{
    public function index()
{
    if (!Gate::allows('admin')) {
        abort(403);
    }
    return view('inventory.index');
}
}
