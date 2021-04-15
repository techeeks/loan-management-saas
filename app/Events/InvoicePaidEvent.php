<?php

namespace App\Events;

use App\Models\Invoice;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoicePaidEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The invoice instance.
     *
     * @var \App\Models\Invoice
     */
    public $invoice;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
}
