<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run()
    {
        $leads = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+6281234567890',
                'source' => 'Website',
                'message' => 'Interested in your services',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+6287654321098',
                'source' => 'Facebook',
                'message' => 'Please contact me for more information',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($leads as $lead) {
            Lead::create($lead);
        }
    }
}
