<?php

namespace App\Listeners;

use App\Events\InvoiceViewedEvent;
use App\Notifications\InvoiceViewed;
use Illuminate\Support\Facades\Notification;

class InvoiceViewedListener
{
    /**
     * Handle the event.
     *
     * @param  InvoiceViewedEvent  $event
     * @return void
     */
    public function handle(InvoiceViewedEvent $event)
    {
        $invoice = $event->invoice;
        $currentCompany = $event->invoice->company;

        // Send Notification to Company User
        $notifyUsers = $currentCompany->users()->get()->filter(function ($user) {
            return $user->getSetting('notification_invoice_viewed');
        });
        Notification::send($notifyUsers, new InvoiceViewed($invoice));
    }
}
