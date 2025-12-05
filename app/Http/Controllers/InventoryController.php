<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;

            $query->where('item_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('item_code', 'LIKE', '%' . $searchTerm . '%');
        }

        $inventories = $query->get();
        return response()->json($inventories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|unique:inventories|max:255',
            'item_code' => 'required|string|unique:inventories|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
        ]);

        $inventory = Inventory::create($request->all());
        return response()->json($inventory, 201);
    }

    public function show(Inventory $inventory)
    {
        return response()->json($inventory);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'item_name' => 'required|string|max:255|unique:inventories,item_name,' . $inventory->id,
            'item_code' => 'required|string|max:50|unique:inventories,item_code,' . $inventory->id,
            'stock_quantity' => 'integer|min:0',
            'cost_price' => 'numeric|min:0',
        ]);

        $inventory->update($request->all());
        return response()->json($inventory);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json(null, 204);
    }
}
