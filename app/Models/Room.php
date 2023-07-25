<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Booking;

class Room extends Model
{
    use HasFactory;
    
    protected $fillable = [
      'name',
      'rate',
      'room_number',
      'description',
      'max_occupancy',
      'is_available',
      'status',
      'cover_image',
      'size',
      'floor',
      'beds',
    ];
    protected $casts = [
      'is_available' => 'boolean'
    ];
    protected $appends = [
      'rate_formatted',
      'cover_image_url',
    ];

    public function bookings(): HasMany {
      return $this->hasMany(Booking::class);
    }

    public function getRateFormattedAttribute() {
      return number_format($this->rate, 2);
    }

    public function getCoverImageUrlAttribute() {
      return '/images/' . $this->cover_image;
    }
    
}
