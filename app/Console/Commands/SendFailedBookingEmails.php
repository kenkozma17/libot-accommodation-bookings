<?php

namespace App\Console\Commands;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;

class SendFailedBookingEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-failed-booking-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out failed booking emails to guest and lobby.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $bookingIds = [169, 172, 173];
            foreach($bookingIds as $id) {
                $booking = Booking::find($id);

                if($booking) {
                    \Mail::to($booking->guest->email)
                        ->cc([env("FRONT_DESK_EMAIL"), env('SUPPORT_EMAIL')])
                        ->send(new BookingConfirmationMail($booking));
                }
            }
            $this->info('Emails Sent!');
        } catch (\Exception $e) {
            $this->error('Something went wrong! ' . $e->getMessage());
        }
    }
}
