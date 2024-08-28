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

    protected $appends = ['total', 'date'];

    public function getDateAttribute() {
        return Carbon::parse($this->created_at)->format('M d, Y');
    }

    public function guest(): BelongsTo {
        return $this->belongsTo(Guest::class);
    }

    public function booking(): BelongsTo {
        return $this->belongsTo(Booking::class);
    }

    public function transactions(): HasMany {
        return $this->hasMany(FolioTransaction::class)->orderBy('created_at', 'desc');
    }

    public function getTotalAttribute() {
        $total = 0;
        foreach($this->transactions as $transaction) {
            $total += (int) $transaction->amount;
        }
        return 'P' . number_format($total, 2);
    }


}
