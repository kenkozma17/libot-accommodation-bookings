<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventSet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'notes'];

    public function services(): BelongsToMany {
      return $this
        ->belongsToMany(
          Service::class,
          'event_set_services',
          'event_set_id',
          'service_id');
    }
}
