<?php

namespace App\Infrastructure\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    protected $template;

    protected $title;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $title, $data)
    {
        $this->template = $template;
        $this->title = $title;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = config('mail.from.address');
        $name = config('mail.from.name');

        return $this->view($this->template)
            ->from($address, $name)
            ->subject($this->title)
            ->with(['data' => $this->data]);
    }
}
