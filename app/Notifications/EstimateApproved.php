<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EstimateApproved extends Notification
{
    /**
     * Public Variables
     */
    public $estimate;
    public $company;

    /**
     * Create a notification instance.
     *
     * @param \App\Models\Estimate  $estimate
     * @return void
     */
    public function __construct($estimate)
    {
        $this->estimate = $estimate;
        $this->company = $estimate->company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('messages.estimate_approved', ['estimate_number' => $this->estimate->estimate_number]))
            ->view('emails.notifications.notification', ['company' => $this->company, 'mail_content' => __('messages.estimate_approved', ['estimate_number' => $this->estimate->estimate_number])]);
    }
}