<?php

namespace App\Http\Controllers;

use App\Models\Rfq;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\VendorController;

class RfqController extends Controller
{
    public function index(Request $request)
    {
        $rfqs = $request->user()->company->rfqs()->latest()->get();
        return Inertia::render('Rfq/Index', ['rfqs' => $rfqs]);
    }

    public function create()
    {
        return Inertia::render('Rfq/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'items_required' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        $request->user()->company->rfqs()->create([
            'title' => $request->title,
            'description' => $request->description,
            'items_required' => $request->items_required,
            'deadline' => $request->deadline,
            'status' => 'Active',
        ]);

        return redirect()->route('rfqs.index')->with('message', 'RFQ Created Successfully!');
    }
    public function show(Request $request, Rfq $rfq)
    {
        if ($rfq->company_id !== $request->user()->company_id) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Rfq/Show', [
            'rfq' => $rfq
        ]);
    }
    public function edit(Request $request, Rfq $rfq)
        {
            if ($rfq->company_id !== $request->user()->company_id) abort(403);
            
            return Inertia::render('Rfq/Edit', ['rfq' => $rfq]);
        }

    public function update(Request $request, Rfq $rfq)
        {
            if ($rfq->company_id !== $request->user()->company_id) abort(403);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'deadline' => 'required|date',
                'status' => 'required|string',
            ]);

            $rfq->update($request->only('title', 'description', 'deadline', 'status'));

            return redirect()->route('rfqs.show', $rfq->id);
        }

    public function destroy(Request $request, Rfq $rfq)
        {
            if ($rfq->company_id !== $request->user()->company_id) abort(403);
            
            $rfq->delete();

            return redirect()->route('rfqs.index');
        }
}