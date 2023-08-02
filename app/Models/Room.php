<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Booking;
use App\Models\Amenity;
use App\Models\RoomUnavailability;
use Carbon\Carbon;

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
      'full_room_name',
    ];
    protected $with = [
      'unavailableDates',
      'amenities',
      'images'
    ];

    public function images(): HasMany {
      return $this->hasMany(RoomImage::class);
    }

    public function amenities(): BelongsToMany {
      return $this->belongsToMany(Amenity::class, 'room_amenities');
    }

    public function bookings(): HasMany {
      return $this->hasMany(Booking::class);
    }

    public function unavailableDates(): HasMany {
      return $this->hasMany(RoomUnavailability::class);
    }

    public function getFullRoomNameAttribute() {
      return $this->name . ' (' . $this->room_number . ')'; 
    }

    public function getRateFormattedAttribute() {
      return number_format($this->rate, 2);
    }

    public function getCoverImageUrlAttribute() {
      if($this->cover_image) {
        return '/images/rooms/' . $this->cover_image;
      } 
      return '/images/room/default-image.jpeg';
    }
    
}
