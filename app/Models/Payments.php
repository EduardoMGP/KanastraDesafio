<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'debitId',
        'paidAt',
        'paidAmount',
        'paidBy',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'debitId', 'debtId');
    }
}
