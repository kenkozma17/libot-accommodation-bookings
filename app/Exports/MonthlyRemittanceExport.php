<?php

namespace App\Exports;

use App\Models\Folio;
use App\Models\FolioTransaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use function PHPSTORM_META\map;

class MonthlyRemittanceExport implements FromCollection, WithHeadings, WithMapping
{
  use Exportable;

  protected $start_date, $end_date;

  public function __construct($start_date, $end_date) {
    $this->start_date = $start_date;
    $this->end_date = $end_date;
  }

  public function collection() {
    $dailyTransactionsList = FolioTransaction::
      whereBetween('date_placed', [$this->start_date, $this->end_date])
      ->where('is_paid', true)
      ->orderBy('date_placed')
      ->get()
      ->groupBy(fn ($t) => $t->date_placed);

    return $dailyTransactionsList;
  }

  public function map($dailyTransactions): array
  {
    return [
      $dailyTransactions->first()->date_placed,
      collect($dailyTransactions->map(function($transaction) { // Accommodation
        if($transaction->service->category->name === 'Accommodation') {
          return (float) $transaction->amount;
        }
      }))->sum(),
      "", // Extra Pax
      collect($dailyTransactions->map(function($transaction) { // Restaurant
        if($transaction->service->category->name === 'Restaurant') {
          return (float) $transaction->amount;
        }
      }))->sum(),
      collect($dailyTransactions->map(function($transaction) { // Entrance
        if($transaction->service->category->name === 'Entrance') {
          return (float) $transaction->amount;
        }
      }))->sum(),
      collect($dailyTransactions->map(function($transaction) { // Rental
        if($transaction->service->category->name === 'Rental') {
          return (float) $transaction->amount;
        }
      }))->sum(),
      collect($dailyTransactions->map(function($transaction) { // Pool
        if($transaction->service->category->name === 'Pool') {
          return (float) $transaction->amount;
        }
      }))->sum(),
      collect($dailyTransactions->map(function($transaction) { // Wifi
        if($transaction->service->category->name === 'Wifi') {
          return (float) $transaction->amount;
        }
      }))->sum(),
    ];
  }

  public function headings(): array
  {
    return [
      'Date',
      'Accommodation',
      'Extra Pax',
      'Restaurant',
      'Entrance',
      'Rental',
      'Pool',
      'Wifi',
      'Total',
    ];
  }

}
