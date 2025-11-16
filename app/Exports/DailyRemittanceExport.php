<?php

namespace App\Exports;

use App\Models\Folio;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use function PHPSTORM_META\map;

class DailyRemittanceExport implements FromQuery, WithHeadings, WithMapping
{
  use Exportable;

  protected $date;

  public function __construct($date) {
    $this->date = $date;
  }

  public function query() {
    $folios = Folio::query()->with([
      'guest',
      'booking',
      'transactions' => function($query) {
        $query->where('date_placed', $this->date)
          ->where('is_paid', true);
      }])->whereHas('transactions', function($query) {
        $query->where('date_placed', $this->date);
      });

    return $folios;
  }

  public function map($folio): array
    {

      # Get booking data

      return [
        $folio->created_at,
        $folio->registration_number,
        $folio->geust ? $folio->guest->first_name . ' ' . $folio->guest->last_name : 'N/A',
        $folio->booking ? $folio->booking->rate_per_night : "",
        $folio->booking ? $folio->booking->stay_length_number : "",
        "", # Intentionally blank
        $folio->booking ? $folio->booking->total_price : "",
        $folio->meals_total,
        $folio->entrance_total, # Entrance Category
        $folio->rental_total, # Rental Category
        $folio->pool_total, # Pool Category
        $folio->gross_total, # Get sum of items from line 49 to 53
        $folio->downpayment_total, # Downpayment category
        $folio->discount_total, # Create a special discount category
        (float) ($folio->gross_total - $folio->downpayment_total - $folio->discount_total), # Gross less deposit, discount
        $folio->cash_total,
        $folio->gcash_maya_total,
        $folio->card_total,
        "" # Intentionally blank
      ];
    }

    public function headings(): array
    {
        return [
            'Date',
            'Reg. Form',
            'Guest Name',
            'Rm Rates',
            'No. of Days',
            'S.I/P.O',
            'ACC',
            'Meals',
            'Entrance',
            'Rental',
            'Pool',
            'Gross',
            'Deposit',
            'Disc.',
            'NET',
            'Cash',
            'G-Cash/Maya',
            'CCard',
            'Receivables'
        ];
    }
}
