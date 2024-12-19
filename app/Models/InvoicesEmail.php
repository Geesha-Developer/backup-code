<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesEmail extends Model
{
    use HasFactory;

    protected $table = 'invoices_email';

    protected $fillable = [
        'from_email',
        'to_email',
        'subject',
        'message',
        'attachments'
    ];


}
