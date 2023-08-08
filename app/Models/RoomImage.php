<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    protected $fillable = [
      'room_id',
      'image_url',
      'is_primary'
    ];

    protected $appends = [
      'image_url_path'
    ];

    public function getImageUrlPathAttribute() {
      return '/images/rooms/' . $this->image_url;
    }
}
