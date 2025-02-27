<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'source' => 'required|string|max:255',
                'message' => 'required|string'
            ]);

            $lead = Lead::create($validated);

            // Forward to third-party service (Slack webhook example)
            $webhookUrl = env('SLACK_WEBHOOK_URL');
            if ($webhookUrl) {
                Http::post($webhookUrl, [
                    'text' => "New lead received!\nName: {$lead->name}\nEmail: {$lead->email}\nPhone: {$lead->phone}\nSource: {$lead->source}\nMessage: {$lead->message}"
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $lead
            ], 201);
        } catch (\Exception $e) {
            ErrorLog::create([
                'error_message' => $e->getMessage(),
                'endpoint' => '/api/leads',
                'status_code' => 500,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error creating lead'
            ], 500);
        }
    }

    public function index()
    {
        try {
            $leads = Lead::all();
            return response()->json([
                'success' => true,
                'data' => $leads
            ]);
        } catch (\Exception $e) {
            ErrorLog::create([
                'error_message' => $e->getMessage(),
                'endpoint' => '/api/leads',
                'status_code' => 500,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving leads'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $lead = Lead::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $lead
            ]);
        } catch (\Exception $e) {
            ErrorLog::create([
                'error_message' => $e->getMessage(),
                'endpoint' => "/api/leads/{$id}",
                'status_code' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 'Lead not found' : 'Error retrieving lead'
            ], $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|max:255',
                'phone' => 'sometimes|string|max:20',
                'source' => 'sometimes|string|max:255',
                'message' => 'sometimes|string'
            ]);

            $lead->update($validated);

            return response()->json([
                'success' => true,
                'data' => $lead
            ]);
        } catch (\Exception $e) {
            ErrorLog::create([
                'error_message' => $e->getMessage(),
                'endpoint' => "/api/leads/{$id}",
                'status_code' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 'Lead not found' : 'Error updating lead'
            ], $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500);
        }
    }

    public function destroy($id)
    {
        try {
            $lead = Lead::findOrFail($id);
            $lead->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lead deleted successfully'
            ]);
        } catch (\Exception $e) {
            ErrorLog::create([
                'error_message' => $e->getMessage(),
                'endpoint' => "/api/leads/{$id}",
                'status_code' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 'Lead not found' : 'Error deleting lead'
            ], $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500);
        }
    }
}
