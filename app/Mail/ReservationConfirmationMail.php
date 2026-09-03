<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ReservationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;
    public string $confirmUrl;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;

        $this->confirmUrl = URL::temporarySignedRoute(
            'reservations.confirm',
            now()->addHours(24),
            ['reservation' => $reservation->id]
        );
    }

    public function build()
    {
        return $this->subject('Confirmez votre réservation Carvix')
            ->view('emails.reservation-confirmation');
    }
}