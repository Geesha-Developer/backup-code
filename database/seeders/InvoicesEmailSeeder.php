<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoicesEmail;

class InvoicesEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define sample data
        $data = [
            [
                'load_id' => 1,
                'invoice_user_id' => 1,
                'from_email' => 'sender@example.com',
                'to_email' => 'recipient@example.com',
                'subject' => 'Sample Invoice',
                'message' => 'Please find attached the sample invoice.',
                'attachments' => json_encode(['invoice.pdf']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'load_id' => 2,
                'invoice_user_id' => 2,
                'from_email' => 'sender2@example.com',
                'to_email' => 'recipient2@example.com',
                'subject' => 'Another Invoice',
                'message' => 'Attached is the invoice for your review.',
                'attachments' => json_encode(['invoice2.pdf']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more sample data as needed
        ];

        // Insert data using Eloquent ORM
        foreach ($data as $item) {
            InvoicesEmail::create($item);
        }
    }
}