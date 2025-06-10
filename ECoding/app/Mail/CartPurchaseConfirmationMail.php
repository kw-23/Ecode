<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Purchase;
use App\Models\Client;

class CartPurchaseConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $purchases;
    public $client;
    public $totalAmount;

    /**
     * Create a new message instance.
     */
    public function __construct(Collection $purchases, Client $client)
    {
        $this->purchases = $purchases;
        $this->client = $client;
        $this->totalAmount = $purchases->sum('amount');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Thank You for Your Purchase! - Your Courses are Ready',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): \Illuminate\Mail\Mailables\Content
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.cart-purchase-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
} 