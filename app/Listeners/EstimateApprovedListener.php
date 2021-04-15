<?php

namespace App\Listeners;

use App\Events\EstimateApprovedEvent;
use App\Notifications\EstimateApproved;
use Illuminate\Support\Facades\Notification;

class EstimateApprovedListener
{
    /**
     * Handle the event.
     *
     * @param  EstimateApprovedEvent  $event
     * @return void
     */
    public function handle(EstimateApprovedEvent $event)
    {
        $estimate = $event->estimate;
        $currentCompany = $event->estimate->company;

        // Send Notification to Company User
        $notifyUsers = $currentCompany->users()->get()->filter(function ($user) {
            return $user->getSetting('notification_estimate_approved_or_rejected');
        });
        Notification::send($notifyUsers, new EstimateApproved($estimate));
    }
}
