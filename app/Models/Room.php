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
use Illuminate\Support\Str;

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
      'size_formatted',
      'beds_formatted',
      'primary_image_url',
      'short_description',
    ];
    protected $with = [
      'unavailableDates',
      'amenities',
      'images'
    ];

    public function images(): HasMany {
      return $this->hasMany(RoomImage::class)->orderBy('is_primary', 'desc');
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

    public function getBedsFormattedAttribute() {
      return ($this->beds === 1) ? $this->beds . ' bed' : $this->beds . ' beds';
    }

    public function getSizeFormattedAttribute() {
      return number_format($this->size, 0) . ' sqm';
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
      return '/images/rooms/default-image.jpeg';
    }

    public function getPrimaryImageUrlAttribute() {
      $primaryImage = $this->images()->where('is_primary', 1)->first();
      return $primaryImage ? $primaryImage : '/images/room/default-image.jpeg';
    }

    public function getShortDescriptionAttribute() {
      return Str::words($this->description, 20, '...');
    }
    
}
