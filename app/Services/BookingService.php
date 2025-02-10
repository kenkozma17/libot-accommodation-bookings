<?php

namespace App\Services;

use App\Models\RoomUnavailability;

class BookingService
{
    public function createRoomUnavailablility($newBooking, $isConfirmed = false) {
        $newUnavailability = RoomUnavailability::create([
          'room_id' => $newBooking->room_id,
          'booking_id' => $newBooking->id,
          'start_date' => $newBooking->check_in,
          'end_date' => $newBooking->check_out,
          'notes' => null,
          'is_range' => true,
          'is_confirmed' => $isConfirmed
        ]);

        return $newUnavailability;
      }
}
