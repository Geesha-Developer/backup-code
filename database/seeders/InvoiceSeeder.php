<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoicesEmail;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvoicesEmail::create([
            'from_email' => 'adam@cargoconvoy.co',
            'to_email' => 'sumit@geeshasolutions.com',
            'subject' => 'Test Invoice',
            'message' => 'This is a test invoice message.',
            'attachments' => ['file1.pdf', 'file2.jpg'] // Example attachments
        ]);
    }
}
