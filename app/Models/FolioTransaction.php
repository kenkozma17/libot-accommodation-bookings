<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\Folio;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FolioTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'description', 'payment_method', 'is_paid'];
    protected $with = ['service'];

    protected $appends = [
        'formatted_price',
        'formatted_amount'
    ];

    public function service(): BelongsTo {
        return $this->belongsTo(Service::class);
    }

    public function folio(): BelongsTo {
        return $this->belongsTo(Folio::class);
    }

    public function getFormattedPriceAttribute() {
        return 'P' . number_format($this->price, 2);
    }

    public function getFormattedAmountAttribute() {
        return 'P' . number_format($this->amount, 2);
    }
}
