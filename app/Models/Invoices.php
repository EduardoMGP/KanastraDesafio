<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $appends = [
        'isPaid'
    ];

    protected $fillable = [
        'debtId',
        'name',
        'governmentId',
        'email',
        'debtAmount',
        'debtDueDate',
    ];

    public function payments()
    {
        return $this->hasMany(Payments::class, 'debitId', 'debtId');
    }

    public function isPaid() : Attribute {
        return Attribute::make('isPaid', function () {
            return 'eee';
        });
    }
}
