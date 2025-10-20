<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Event extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'type',
      'pax',
      'setup_time',
      'start_time',
      'end_time',
      'serving_time',
      'start_date',
      'end_date',
      'notes',
      'status',
      'guest_id'
    ];

    public function guest(): BelongsTo {
      return $this->belongsTo(Guest::class);
    }

    public function sets(): BelongsToMany {
      return $this->belongsToMany(
        EventSet::class,
        'event_event_sets',
        'event_id',
        'event_set_id',
      );
    }

}
