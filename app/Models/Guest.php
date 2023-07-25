<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guest extends Model
{
    use HasFactory;
    protected $fillable = [
      'first_name',
      'last_name',
      'email',
      'phone',
      'nationality',
    ];

    protected $appends = [
      'full_name'
    ];

    public function bookings(): HasMany {
      return $this->hasMany(Booking::class);
    }

    public function payments(): HasMany {
      return $this->hasMany(Payment::class);
    }

    public function getFullNameAttribute() {
      return $this->first_name . ' ' . $this->last_name;
    }
}
