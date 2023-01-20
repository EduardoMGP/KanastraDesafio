<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketsEmailQueues
 * @package App\Models
 *
 * @property int $id
 * @property string $email
 * @property string $ticket_barcode
 * @property int $debtId
 * @property string $status
 * @property Invoices $invoice
 */
class TicketsEmailQueues extends Model
{
    use HasFactory;

    const STATUS_PENDING = "pending";
    const STATUS_SENT = "sent";
    const STATUS_FAILED = "failed";

    protected $fillable = [
        'id',
        'email',
        'ticket_barcode',
        'debtId',
        'status',
    ];
}
