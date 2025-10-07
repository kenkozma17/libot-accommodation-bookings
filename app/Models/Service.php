<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'formatted_price',
        'est_unit_cost',
    ];
    protected $fillable = ['name', 'description', 'price', 'service_category_id', 'slug'];

    public function category(): BelongsTo {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function inventory_items(): BelongsToMany {
      return $this
        ->belongsToMany(InventoryItem::class, 'service_inventory_items', 'service_id', 'inventory_item_id')
        ->withPivot(['quantity', 'unit']);
    }

    public function getEstUnitCostAttribute() {
      if($this->inventory_items) {
        $costsPerItem = $this->inventory_items->map(function($item) {
          return $item->pivot->quantity * $item->est_cost;
        }, $this->inventory_items);

        return $costsPerItem->sum();
      }
      return 0;
    }

    public function getFormattedPriceAttribute() {
        return 'P' . number_format($this->price, 2);
    }
}
