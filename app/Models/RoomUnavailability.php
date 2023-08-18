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

    protected $casts = [
      'is_confirmed' => 'boolean'
    ];

    protected $fillable = [
      'room_id',
      'booking_id',
      'start_date',
      'end_date',
      'notes',
      'is_range',
      'is_confirmed',
    ];

    public function booking(): BelongsTo {
      return $this->belongsTo(Booking::class);
    }
}
