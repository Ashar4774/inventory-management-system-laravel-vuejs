<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('purchase_order/Index', [
            'purchase_orders' => PurchaseOrder::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::get();
        $categories = Category::get();
        $inventories = Inventory::with('category')->get();

        return Inertia::render('purchase_order/Create', [
            'vendors' => $vendors,
            'categories' => $categories,
            'inventories' => $inventories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
