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

    /** @var Collection $newCars */
    private $newCars;

    /** @var string $cssPath */
    private $cssPath;

    /** @var string $title */
    private $title;

    /**
     * Create a new message instance.
     *
     * @param Collection $newCars
     */
    public function __construct($title, Collection $newCars, $cssPath = '')
    {
        $this->title = $title;
        $this->newCars = $newCars;
        $this->cssPath = $cssPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_cars')
          ->with([
                'title'   => $this->title,
                'newCars' => $this->newCars,
                'cssPath' => $this->cssPath,
            ])
            ->withSwiftMessage(function(\Swift_Message $message) {
                $message->getHeaders()->addTextHeader('Content-type', 'text/plain; charset=ISO-8859-1');
            });
    }
}
