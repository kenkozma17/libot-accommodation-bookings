<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Guest;
use App\Models\Payment;
use App\Models\Room;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
      'booking_confirmation',
      'check_in',
      'check_out',
      'rate_per_night',
      'total_price',
      'booking_status',
      'special_requests',
      'adults_count',
      'children_count',
      'guest_id',
      'room_id',
      'payment_id',
    ];

    protected $with = [
      'guest',
      'payment',
      'room'
    ];
    protected $appends = [
      'check_in_formatted',
      'check_out_formatted',
      'created_at_formatted',
      'rate_per_night_formatted',
      'stay_length'
    ];

    public function room(): BelongsTo {
      return $this->belongsTo(Room::class);
    }

    public function guest(): BelongsTo {
      return $this->belongsTo(Guest::class);
    }

    public function payment(): BelongsTo {
      return $this->belongsTo(Payment::class);
    }

    public function getRatePerNightFormattedAttribute() {
      return number_format($this->rate_per_night, 2);
    }

    public function getStayLengthAttribute() {
      $checkIn = Carbon::parse($this->check_in);
      $checkOut = Carbon::parse($this->check_out);
      return $checkIn->diffInDays($checkOut) . ' Night/s';
    }

    public function getCheckInFormattedAttribute() {
      return Carbon::parse($this->check_in)->format('M d, Y');
    }

    public function getCheckOutFormattedAttribute() {
      return Carbon::parse($this->check_out)->format('M d, Y');
    }

    public function getCreatedAtFormattedAttribute() {
      return Carbon::parse($this->created_at)->format('M d, Y');
    }
}
