<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ServiceCategory;

class Service extends Model
{
    use HasFactory;

    protected $appends = [
        'formatted_price'
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function getFormattedPriceAttribute() {
        return 'P' . number_format($this->price, 2);
    }
}
