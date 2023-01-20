<?php

namespace App\Models;

use App\Traits\FormatTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

/**
 * Class Payments
 * @package App\Models
 *
 * @property int $id
 * @property int $debtId
 * @property Date $paidAt
 * @property float $paidAmount
 * @property string $paidBy
 */
class Payments extends Model
{
    use HasFactory, FormatTrait;

    protected $appends = [
        'paidAmountFormat',
        'paidAtFormat',
        'createdAtFormat',
    ];

    protected $fillable = [
        'id',
        'debtId',
        'paidAt',
        'paidAmount',
        'paidBy',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'debtId', 'debtId');
    }

    /**
     * @return string
     */
    public function getPaidAmountFormatAttribute()
    {
        return $this->moneyFormat($this->attributes['paidAmount']);
    }

    /**
     * @return Attribute
     */
    public function paidAmountFormat(): Attribute
    {
        return Attribute::make(function () {
            return $this->moneyFormat($this->attributes['paidAmount']);
        })->withoutObjectCaching();
    }

    /**
     * @return string
     */
    public function getPaidAtFormatAttribute()
    {
        return $this->dateTimeFormat($this->attributes['paidAt']);
    }

    /**
     * @return Attribute
     */
    public function paidAtFormat(): Attribute
    {
        return Attribute::make(function () {
            return $this->getPaidAtFormatAttribute();
        })->withoutObjectCaching();
    }


    /**
     * @return string
     */
    public function getCreatedAtFormatAttribute()
    {
        return isset($this->attributes['created_at']) ? $this->dateTimeFormat($this->attributes['created_at']) : null;
    }

    /**
     * @return Attribute
     */
    public function createdAtFormat(): Attribute
    {
        return Attribute::make(function () {
            return $this->getCreatedAtFormatAttribute();
        })->withoutObjectCaching();
    }
}
