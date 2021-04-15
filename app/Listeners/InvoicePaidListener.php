<?php

namespace App\Listeners;

use App\Events\InvoicePaidEvent;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;

class InvoicePaidListener
{
    /**
     * Handle the event.
     *
     * @param  InvoicePaidEvent  $event
     * @return void
     */
    public function handle(InvoicePaidEvent $event)
    {
        $invoice = $event->invoice;
        $currentCompany = $event->invoice->company;

        // Send Notification to Company User
        $notifyUsers = $currentCompany->users()->get()->filter(function ($user) {
            return $user->getSetting('notification_invoice_paid');
        });
        Notification::send($notifyUsers, new InvoicePaid($invoice));
    }
}
