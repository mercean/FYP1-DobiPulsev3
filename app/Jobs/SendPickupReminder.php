<?php

namespace App\Jobs;

use App\Models\BulkOrder;
use App\Notifications\PickupReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPickupReminder implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $bulkOrderId;

    public function __construct($bulkOrderId)
    {
        $this->bulkOrderId = $bulkOrderId;
    }

    public function handle(): void
    {
        $order = BulkOrder::with('user')->find($this->bulkOrderId);

        if ($order && $order->status === 'waiting pickup') {
            $order->user->notify(new PickupReminder($order));
        }
    }
}
