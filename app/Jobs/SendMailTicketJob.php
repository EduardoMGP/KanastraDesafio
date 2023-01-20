<?php

namespace App\Jobs;

use App\Models\TicketsEmailQueues;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ticketEmailQueue;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TicketsEmailQueues $ticketEmailQueue)
    {
        $this->ticketEmailQueue = $ticketEmailQueue;
    }

    public function handle()
    {
        if ($this->ticketEmailQueue->status != TicketsEmailQueues::STATUS_SENT) {
            $this->ticketEmailQueue->ticket_barcode = $this->generateTicketBarcode();
            $this->ticketEmailQueue->status = TicketsEmailQueues::STATUS_SENT;
            $this->ticketEmailQueue->save();
            $this->sendMail();
        }

    }

    private function generateTicketBarcode()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 15; $i++)
            $randomString .= $characters[rand(0, $charactersLength - 1)];

        return $randomString;
    }

    public function sendMail()
    {
        echo "Sending mail to: " . $this->ticketEmailQueue->email . PHP_EOL;
    }
}
