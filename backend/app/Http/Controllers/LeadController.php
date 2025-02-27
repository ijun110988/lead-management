<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    // 🔹 POST /api/leads - Simpan lead & forward ke third-party
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email',
            'phone' => 'required|string|max:15',
            'source' => 'required|string',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            // Simpan lead ke database
            $lead = Lead::create($request->all());

            // 🔹 Forward ke third-party (contoh Slack webhook)
            $webhookUrl = env('THIRD_PARTY_API_URL');
            Http::post($webhookUrl, [
                'text' => "New Lead: {$lead->name}, Email: {$lead->email}",
            ]);

            return response()->json(['message' => 'Lead stored successfully', 'lead' => $lead], 201);
        } catch (\Exception $e) {
            // Log error
            ErrorLog::create([
                'error_message' => $e->getMessage(),
                'endpoint' => '/api/leads',
                'status_code' => 500,
            ]);

            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    // 🔹 GET /api/leads - Ambil semua leads
    public function index()
    {
        return response()->json(Lead::all());
    }

    // 🔹 GET /api/leads/{id} - Ambil detail lead
    public function show($id)
    {
        $lead = Lead::find($id);

        if (!$lead) {
            return response()->json(['error' => 'Lead not found'], 404);
        }

        return response()->json($lead);
    }
}
// namespace App\Http\Controllers;

// use App\Models\Lead;
// use App\Models\ErrorLog;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Validator;

// class LeadController extends Controller
// {
//     // 🔹 POST /api/leads - Simpan lead & forward ke third-party
//     public function store(Request $request)
//     {
//         // Validasi input
//         $validator = Validator::make($request->all(), [
//             'name' => 'required|string|max:255',
//             'email' => 'required|email|unique:leads,email',
//             'phone' => 'required|string|max:15',
//             'source' => 'required|string',
//             'message' => 'nullable|string',
//         ]);

//         if ($validator->fails()) {
//             return response()->json($validator->errors(), 400);
//         }

//         try {
//             // Simpan lead ke database
//             $lead = Lead::create($request->all());

//             // 🔹 Forward ke third-party (contoh Slack webhook)
//             $webhookUrl = env('THIRD_PARTY_API_URL');
//             Http::post($webhookUrl, [
//                 'text' => "New Lead: {$lead->name}, Email: {$lead->email}",
//             ]);

//             return response()->json(['message' => 'Lead stored successfully', 'lead' => $lead], 201);
//         } catch (\Exception $e) {
//             // Log error
//             ErrorLog::create([
//                 'error_message' => $e->getMessage(),
//                 'endpoint' => '/api/leads',
//                 'status_code' => 500,
//             ]);

//             return response()->json(['error' => 'Something went wrong'], 500);
//         }
//     }

//     // 🔹 GET /api/leads - Ambil semua leads
//     public function index()
//     {
//         return response()->json(Lead::all());
//     }

//     // 🔹 GET /api/leads/{id} - Ambil detail lead
//     public function show($id)
//     {
//         $lead = Lead::find($id);

//         if (!$lead) {
//             return response()->json(['error' => 'Lead not found'], 404);
//         }

//         return response()->json($lead);
//     }
// }

