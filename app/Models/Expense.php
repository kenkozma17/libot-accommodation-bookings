<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'expense_date',
        'notes',
        'payment_method',
        'vendor',
        'invoice_number',
        'type'
    ];

    protected $appends = ['expense_date_formatted'];

    public function getExpenseDateFormattedAttribute() {
        return Carbon::parse($this->expense_date)->format('M d, Y');
    }
}
