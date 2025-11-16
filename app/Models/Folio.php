<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Guest;
use App\Models\Booking;
use App\Models\FolioTransaction;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Folio extends Model
{
    use HasFactory;

    protected $fillable = ['guest_id', 'booking_id'];
    protected $with = ['guest', 'booking'];

    protected $appends = [
      'total',
      'date',
      'meals_total',
      'entrance_total',
      'rental_total',
      'downpayment_total',
      'pool_total',
      'cash_total',
      'gcash_maya_total',
      'card_total',
      'discount_total',
      'gross_total',
    ];

    public function getDateAttribute() {
        return Carbon::parse($this->created_at)->format('M d, Y');
    }

    public function guest(): BelongsTo {
        return $this->belongsTo(Guest::class);
    }

    public function booking(): BelongsTo {
        return $this->belongsTo(Booking::class);
    }

    public function event(): BelongsTo {
      return $this->belongsTo(Event::class);
    }

    public function transactions(): HasMany {
        return $this->hasMany(FolioTransaction::class)->orderBy('created_at', 'desc');
    }

    public function getTotalFromMethod($method) {
      $total = 0;
      foreach($this->transactions as $transaction) {
        if($transaction->payment_method === $method) {
          $total += (float) $transaction->amount;
        }
      }

      return number_format($total, 2);
    }

    public function getCardTotalAttribute() {
      return $this->getTotalFromMethod('Credit/Debit Card');
    }

    public function getGcashMayaTotalAttribute() {
      return $this->getTotalFromMethod('Gcash') + $this->getTotalFromMethod('Maya');
    }

    public function getCashTotalAttribute() {
      return $this->getTotalFromMethod('Cash');
    }

    public function getTotalFromCategory($category) {
      $total = 0;
      foreach($this->transactions as $transaction) {
        if($transaction->service->category->name === $category) {
          $total += (int) $transaction->amount;
        }
      }

      return number_format($total, 2);
    }

    public function getDownPaymentTotalAttribute() {
      return $this->getTotalFromCategory('Down Payment');
    }

    public function getDiscountTotalAttribute() {
      return $this->getTotalFromCategory('Discount');
    }

    public function getPoolTotalAttribute() {
      return $this->getTotalFromCategory('Pool');
    }

    public function getRentalTotalAttribute() {
      return $this->getTotalFromCategory('Rental');
    }

    public function getEntranceTotalAttribute() {
      return $this->getTotalFromCategory('Entrance');
    }

    public function getMealsTotalAttribute() {
      return $this->getTotalFromCategory('Restaurant');
    }

    public function getGrossTotalAttribute() {
      $bookingTotal = ($this->booking) ? $this->booking->total_price : 0;
      $totals = [
        $bookingTotal,
        $this->meals_total,
        $this->entrance_total,
        $this->rental_total,
        $this->pool_total
      ];
      return array_sum($totals);
    }

    public function getTotalAttribute() {
        $total = 0;
        foreach($this->transactions as $transaction) {
            $total += (float) $transaction->amount;
        }
        return 'P' . number_format($total, 2);
    }
}
