<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Machine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MarkMachineAvailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
    {
        \Log::info("🧼 Force-running MarkMachineAvailable for Order #{$this->orderId}");
    
        $order = \App\Models\Order::find($this->orderId);
    
        if (!$order || !$order->machine_id) {
            \Log::warning("❌ Order or machine missing for Order #{$this->orderId}");
            return;
        }
    
        $machine = \App\Models\Machine::find($order->machine_id);
    
        if ($machine) {
            $machine->status = 'available';
            $machine->save();
            \Log::info("✅ (Forced) Machine #{$machine->id} set to 'available'");
        } else {
            \Log::warning("⚠️ Machine not found for Order #{$order->id}");
        }
    }
    
}
