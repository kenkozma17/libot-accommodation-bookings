<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
      'type',
      'quantity',
      'unit',
      'inventory_item_id',
      'note',
      'previous_stock',
      'current_stock'
    ];

    protected $appends = ['created_at_formatted'];

    public function getCreatedAtFormattedAttribute() {
      return Carbon::parse($this->created_at)->format('M d, Y h:iA');
    }

    public function item(): BelongsTo {
      return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }
}
