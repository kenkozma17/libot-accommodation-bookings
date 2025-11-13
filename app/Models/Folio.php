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

    protected $appends = ['total', 'date', 'meals_total', 'cash_total', 'gcash_maya_total', 'card_total'];

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

    public function getCardTotalAttribute() {
      $total = 0;
      foreach($this->transactions as $transaction) {
        if($transaction->payment_method === 'Credit/Debit Card') {
          $total += (int) $transaction->amount;
        }
      }

      return 'P' . number_format($total, 2);
    }

    public function getGcashMayaTotalAttribute() {
      $total = 0;
      foreach($this->transactions as $transaction) {
        if($transaction->payment_method === 'Gcash' || $transaction->payment_method === 'Maya') {
          $total += (int) $transaction->amount;
        }
      }

      return 'P' . number_format($total, 2);
    }

    public function getCashTotalAttribute() {
      $total = 0;
      foreach($this->transactions as $transaction) {
        if($transaction->payment_method === 'Cash') {
          $total += (int) $transaction->amount;
        }
      }

      return 'P' . number_format($total, 2);
    }

    public function getMealsTotalAttribute() {
      $total = 0;
      foreach($this->transactions as $transaction) {
        if($transaction->service->category->name === 'Restaurant') {
          $total += (int) $transaction->amount;
        }
      }

      return 'P' . number_format($total, 2);
    }

    public function getTotalAttribute() {
        $total = 0;
        foreach($this->transactions as $transaction) {
            $total += (int) $transaction->amount;
        }
        return 'P' . number_format($total, 2);
    }


}
