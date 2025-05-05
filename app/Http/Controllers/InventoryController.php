<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();
        $inventories = Inventory::with('category')->get();
        return Inertia::render('inventory/Index', ['categories' => $categories, 'inventories' => $inventories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('inventory/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryRequest $request)
    {
        $data = $request->validated();
        Inventory::create($data);

        return redirect()->route('inventory.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inventory = Inventory::with('category')->whereId($id)->first();
        return response()->json([
            'inventory' => $inventory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inventory = Inventory::with('category')->whereId($id)->first();
        return response()->json([
            'inventory' => $inventory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventoryRequest $request, $id)
    {
        $data = $request->validated();
        $inventory = Inventory::findOrFail($id);
        $inventory->update($data);

        return redirect()->route('inventory.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory.index');
    }
}
