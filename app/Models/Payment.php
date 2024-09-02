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

    protected $fillable = [
      'payment_amount',
      'fee',
      'payment_status',
      'payment_date',
      'payment_method',
      'paymongo_payment_id',
      'payer_name',
      'payer_email',
      'payment_gateway',
      'receipt_number',
      'payment_reference',
      'currency_code',
      'payment_source',
      'booking_id',
      'guest_id',
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
