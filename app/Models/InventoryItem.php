<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'unit', 'stock', 'min_level', 'est_cost', 'inventory_category_id'];
    protected $appends = ['est_cost_formatted'];
    protected $with = ['movements'];
    public $units = ['BOX', 'CASE', 'KG', 'LITER', 'METER', 'PCS'];

    public function category(): BelongsTo {
      return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
    }

    public function movements(): HasMany {
      return $this->hasMany(InventoryMovement::class, 'inventory_item_id');
    }

    public function getEstCostFormattedAttribute() {
      if($this->est_cost) {
        return 'P' . number_format($this->est_cost, 2);
      }
    }
}
