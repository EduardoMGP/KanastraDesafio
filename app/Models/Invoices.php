<?php

namespace App\Models;

use App\Traits\FormatTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;

/**
 * Class Invoices
 * @package App\Models
 *
 * @property HasMany $payments
 * @property int $debtId
 * @property string $name
 * @property int $governmentId
 * @property string $email
 * @property float $debtAmount
 * @property Date $debtDueDate
 * @property bool $isPaid
 * @property float $valuePaid
 *
 */
class Invoices extends Model
{
    use HasFactory, FormatTrait;

    public $timestamps = true;
    protected $primaryKey = 'debtId';
    protected $appends = [
        'isPaid',
        'valuePaid',
        'valuePaidFormat',
        'debtAmountFormat',
        'debtDueDateFormat',
    ];

    protected $fillable = [
        'debtId',
        'name',
        'governmentId',
        'email',
        'debtAmount',
        'debtDueDate',
        'paid'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payments::class, 'debtId', 'debtId');
    }

    /**
     * @return HasMany
     */
    public function ticketsEmailQueue()
    {
        return $this->hasMany(TicketsEmailQueues::class, 'debtId', 'debtId');
    }

    /**
     * @return Attribute
     */
    public function isPaid(): Attribute
    {
        return Attribute::make(function () {
            return $this->getIsPaidAttribute();
        })->withoutObjectCaching();
    }

    /**
     * @return bool
     */
    public function getIsPaidAttribute(): bool
    {
        return $this->attributes['debtAmount'] <= $this->payments->sum('paidAmount');
    }

    /**
     * @return Attribute
     */
    public function valuePaid(): Attribute
    {
        return Attribute::make(function () {
            return $this->getValuePaidAttribute();
        })->withoutObjectCaching();
    }

    /**
     * @return double
     */
    public function getValuePaidAttribute()
    {
        return $this->payments->sum('paidAmount');
    }

    /**
     * @return string
     */
    public function getValuePaidFormatAttribute()
    {
        return $this->moneyFormat($this->getValuePaidAttribute());
    }

    /**
     * @return Attribute
     */
    public function valuePaidFormat(): Attribute
    {
        return Attribute::make(function () {
            return $this->getValuePaidFormatAttribute();
        })->withoutObjectCaching();
    }


    /**
     * @return string
     */
    public function getDebtAmountFormatAttribute()
    {
        return $this->moneyFormat($this->attributes['debtAmount']);
    }

    /**
     * @return Attribute
     */
    public function debtAmountFormat(): Attribute
    {
        return Attribute::make(function () {
            return $this->getDebtAmountFormatAttribute();
        })->withoutObjectCaching();
    }

    /**
     * @return string
     */
    public function getDebtDueDateFormatAttribute()
    {
        return $this->dateFormat($this->attributes['debtDueDate']);
    }

    /**
     * @return Attribute
     */
    public function debtDueDateFormat(): Attribute
    {
        return Attribute::make(function () {
            return $this->getDueDateFormatAttribute();
        })->withoutObjectCaching();
    }
}
