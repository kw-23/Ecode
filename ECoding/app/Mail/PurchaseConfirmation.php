<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Purchase;
use App\Models\Course;

class PurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;
    public $course;
    public $client;

    /**
     * Create a new message instance.
     */
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
        $this->course = $purchase->course;
        $this->client = $purchase->client;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Confirmation de votre achat - ' . $this->course->title)
                    ->view('emails.purchase-confirmation');
    }
} 