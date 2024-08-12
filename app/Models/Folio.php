<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasOne;
use App\Models\Guest;
use App\Models\Booking;

class Folio extends Model
{
    use HasFactory;

    protected $fillable = ['guest_id', 'booking_id'];

    public function guest(): BelongsTo {
        return $this->belongsTo(Guest::class);
    }

    public function booking(): BelongsTo {
        return $this->belongsTo(Booking::class);
    }
}
