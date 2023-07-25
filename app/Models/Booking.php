<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $with = ['payment'];
    protected $appends = [
      'check_in_formatted',
      'check_out_formatted',
      'created_at_formatted'
    ];

    public function guest(): HasOne {
      return $this->hasOne(Guest::class);
    }

    public function payment(): HasOne {
      return $this->hasOne(Payment::class);
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
