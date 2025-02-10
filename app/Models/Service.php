<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'formatted_price'
    ];
    protected $fillable = ['name', 'description', 'price', 'service_category_id', 'slug'];

    public function category(): BelongsTo {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function getFormattedPriceAttribute() {
        return 'P' . number_format($this->price, 2);
    }
}
