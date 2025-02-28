<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        return response()->json(Lead::all());
    }

    public function store(Request $request)
    {
        $lead = Lead::create($request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'source' => 'nullable|string',
            'message' => 'nullable|string',
        ]));

        return response()->json($lead, 201);
    }

    public function show(Lead $lead)
    {
        return response()->json($lead);
    }

    public function update(Request $request, Lead $lead)
    {
        $lead->update($request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string',
            'source' => 'nullable|string',
            'message' => 'nullable|string',
        ]));

        return response()->json($lead);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return response()->json(['message' => 'Lead deleted successfully']);
    }
}
