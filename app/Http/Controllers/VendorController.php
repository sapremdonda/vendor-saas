<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->get();
        return Inertia::render('Vendor/Index', ['vendors' => $vendors]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors',
            'company' => 'required|string|max:255',
        ]);

        Vendor::create([
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
        ]);

        return redirect()->route('vendors.index');
    }
}