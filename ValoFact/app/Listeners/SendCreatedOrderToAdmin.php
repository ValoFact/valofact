<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Mail\{CreatedOrderMail, SoldOrderMail, UpdatedOrderMail, ExpiredOrderMail} ;
use App\Models\User;
use Illuminate\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCreatedOrderToAdmin
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
    public function handle(OrderCreatedEvent $event): void
    {   
        if($event->motif === 'creation'){
            //notifications mailing treatement
            $this->mailer->send(new CreatedOrderMail($event->order, $event->user, $event->orderUrl));
        }elseif($event->motif === 'update'){
            //notifications mailing treatement
            foreach($event->order->bids as $bid){
                $biderEmail = (User::find($bid->user_id))->email;
                $this->mailer->send(new UpdatedOrderMail($event->order, $event->user, $event->orderUrl, $biderEmail));
            }
        }elseif($event->motif === 'sold' || $event->motif === 'expired'){
            //notifications mailing treatement
            $this->mailer->send(new SoldOrderMail($event->order, $event->user, $event->orderUrl, $event->lastBid));
        }elseif($event->motif === 'expired&nobids'){
            //notifications mailing treatement
            $this->mailer->send(new ExpiredOrderMail($event->order, $event->user, $event->orderUrl));
        }
    }
}
