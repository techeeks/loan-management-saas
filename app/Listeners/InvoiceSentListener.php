<?php

namespace App\Listeners;

use App\Events\InvoiceSentEvent;
use App\Notifications\InvoiceSent;
use Illuminate\Support\Facades\Notification;

class InvoiceSentListener
{
    /**
     * Handle the event.
     *
     * @param  InvoiceSentEvent  $event
     * @return void
     */
    public function handle(InvoiceSentEvent $event)
    {
        $invoice = $event->invoice;
        $currentCompany = $event->invoice->company;

        // Send Notification to Company User
        $notifyUsers = $currentCompany->users()->get()->filter(function ($user) {
            return $user->getSetting('notification_invoice_sent');
        });
        Notification::send($notifyUsers, new InvoiceSent($invoice));
    }
}
