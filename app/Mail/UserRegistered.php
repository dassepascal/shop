<?php

namespace App\Mail;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;


    Public Shop $shop;

    public function __construct()
    {
        $this->shop = Shop::firstOrFail();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->shop->email, $this->shop->name),
            subject: trans('You have been registered'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.registered',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

