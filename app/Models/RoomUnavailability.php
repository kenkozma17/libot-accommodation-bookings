<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Booking;

class RoomUnavailability extends Model
{
    use HasFactory;

    protected $with = [
      'booking'
    ];

    public function booking(): BelongsTo {
      return $this->belongsTo(Booking::class);
    }
}
