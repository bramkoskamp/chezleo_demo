<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mailgun\Mailgun;
use Illuminate\Support\Facades\Log;
use App\Models\Review;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reservation;

    /**
     * Maak een nieuwe job instantie.  
     *
     * @param $reservation
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Voer de job uit.
     */
    public function handle()
    {
        try {
            // Mailgun Client aanmaken
            $mgClient = Mailgun::create(env('MAILGUN_SECRET'));

            // Gegevens ophalen
            $recipient = 'bramkoskamp@gmail.com'; // Dynamisch de e-mail van de reservering
            
            $reviewExists = Review::where('name', $this->reservation->name)->exists();

            if($reviewExists) {
                $result = $mgClient->messages()->send(env('MAILGUN_DOMAIN'), [
                    'from' => 'chezleo@gmail.com',
                    'to' => $recipient,
                    'subject' => 'Reservering Chez Leo',
                    'html' => view('email.email_review_edit', [
                        'reservation' => $this->reservation,    
                    ])->render(),
                ]);
            }
            else{
                $result = $mgClient->messages()->send(env('MAILGUN_DOMAIN'), [
                    'from' => 'chezleo@gmail.com',
                    'to' => $recipient,
                    'subject' => 'Reservering Chez Leo',
                    'html' => view('email.email_review', [
                        'reservation' => $this->reservation,    
                    ])->render(),
                ]);
            }           

            // Log dat de e-mail succesvol is verzonden
            Log::info("E-mail succesvol verzonden naar {$recipient}");

            // Markeer de reservering als verzonden
            
            if ($result != null) {
                $this->reservation->email_sent = true;
                $this->reservation->save();
            } else {
                return redirect()->back()->with('error', 'Failed to send email.');
            }
            
        } catch (\Exception $e) {
            // Log een fout als de e-mail niet verzonden kan worden
            Log::error("Fout bij verzenden e-mail: " . $e->getMessage());
        }
    }
}
