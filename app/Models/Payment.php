<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $appends = [
      'payment_amount_formatted',
      'payment_date_formatted',
    ];

    public function booking() {
      return $this->belongsTo(Booking::class);
    }

    public function getPaymentAmountFormattedAttribute() {
      return $this->currency_code . ' ' . number_format($this->payment_amount, 2);
    }

    public function getPaymentDateFormattedAttribute() {
      return Carbon::parse($this->payment_date)->format('M d, Y');
    }
}
