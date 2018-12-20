<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Class NewCars
 * @package App\Mail
 * @property Collection $newCars
 */
class NewCars extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param Collection $newCars
     */
    public function __construct(Collection $newCars)
    {
        $this->newCars = $newCars;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_cars')->with('newCars', $this->newCars);
    }
}
