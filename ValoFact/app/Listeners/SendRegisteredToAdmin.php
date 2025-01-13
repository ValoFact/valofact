<?php

namespace App\Listeners;

//use App\Events\Registered;

use App\Mail\RegisteredUserActivationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Registered;
use Illuminate\Mail\Mailer;


class SendRegisteredToAdmin
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
    public function handle(Registered $event): void
    {
        $url = route('activateuser', $event->user);
        $this->mailer->send(new RegisteredUserActivationMail($event->user, $url));
    }
}
