<?php

namespace App\Listeners;

use App\Events\BidEvent;
use App\Mail\{BidCreatedMail, BidOutbidedMail};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Mailer;

class BidListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private Mailer $mailer)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BidEvent $event): void
    {
        if($event->motif === 'created'){
            //notifications mailing treatment
            $this->mailer->send(new BidCreatedMail($event->order, $event->orderUrl));
        }elseif($event->motif === 'outbid'){
            //notifications mailing treatment
            $this->mailer->send(new BidOutbidedMail($event->order, $event->bid, $event->orderUrl));
        }
    }
}
