<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('vendors/Index', [
            'vendors' => Vendor::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VendorRequest $request)
    {
        $data = $request->validated();
        Vendor::create($data);
        return redirect()->route('vendor.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vendor = Vendor::with('inventories')->whereId($id)->first();
        return response()->json([
           'vendor' => $vendor
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vendor = Vendor::whereId($id)->first();
        return response()->json([
            'vendor' => $vendor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VendorRequest $request, $id)
    {
        $data = $request->validated();
        $vendor = Vendor::whereId($id)->first();
        $vendor->update($data);

        return redirect()->route('vendor.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('vendor.index');
    }
}
