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
                'company' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);

            \App\Models\Vendor::create([
                'company_id' => auth()->user()->company_id,
                'company' => $request->company,
                'name' => $request->name,
                'email' => $request->email,
            ]);
            return back();
        }
}