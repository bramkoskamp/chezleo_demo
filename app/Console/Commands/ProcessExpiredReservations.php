<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Jobs\SendMail;
use Carbon\Carbon;

class ProcessExpiredReservations extends Command
{
    protected $signature = 'reservations:process-expired';
    protected $description = 'Verwerk verlopen reserveringen en verstuur e-mails.';

    public function handle()
{
    $now = Carbon::now();

    $reservations = Reservation::whereRaw('DATE_ADD(reservation_time, INTERVAL 3 HOUR) < ?', [$now])
        ->where('email_sent', false)
        ->get();

    if ($reservations->isEmpty()) {
        $this->info('Geen verlopen reserveringen gevonden.');
        return;
    }

    foreach ($reservations as $reservation) {
        SendMail::dispatch($reservation);
    }

    $this->info('Verlopen reserveringen in de wachtrij geplaatst.');
}

}
