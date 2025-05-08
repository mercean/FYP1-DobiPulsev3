@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Title -->
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">🧺 Choose an Available Machine</h2>
        <p class="text-gray-500 dark:text-gray-300 mt-1">Select a machine and customize your laundry session</p>
    </div>

    <!-- Type Filter Dropdown -->
    <div class="mb-6">
        <label for="type_filter" class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Filter by Machine Type:</label>
        <select id="type_filter" class="w-full max-w-xs px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="all">All</option>
            <option value="washer">Washer</option>
            <option value="dryer">Dryer</option>
        </select>
    </div>

    <!-- Machine & Cart Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Machine Table -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">💡 Machine Selection</h3>
            <table class="w-full table-auto text-sm text-left rounded overflow-hidden">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Location</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody id="machine_table_body" class="divide-y dark:divide-gray-600 text-gray-700 dark:text-gray-300">
                    @foreach ($machines as $machine)
                    <tr class="machine-row" data-type="{{ strtolower($machine->type) }}">
                        <td class="px-4 py-2">{{ $machine->id }}</td>
                        <td class="px-4 py-2">{{ ucfirst($machine->type) }}</td>
                        <td class="px-4 py-2">{{ $machine->location ?? '-' }}</td>
                        <td class="px-4 py-2 capitalize">
                            @if (strtolower($machine->status) === 'in_use' && $machine->active_order && $machine->active_order->end_time instanceof \Carbon\Carbon)
                                <span class="countdown text-yellow-500" data-end-time="{{ $machine->active_order->end_time->toIso8601String() }}">Calculating...</span>
                            @elseif (strtolower($machine->status) === 'maintenance')
                                <span class="text-red-500 font-medium">Maintenance</span>
                            @else
                                <span class="text-green-600 font-medium">Available</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                        @if (in_array(strtolower(trim($machine->status)), ['available', 'ready']))

                            <button type="button"
                                class="machine_select_btn bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded"
                                data-machine-id="{{ $machine->id }}">
                                Select
                            </button>
                        @else
                            <button type="button"
                                class="bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed"
                                disabled>
                                Locked
                            </button>
                        @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Cart Summary -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">🛒 Cart Summary</h3>
            <div class="space-y-4">
                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Selected Machine:</strong> <span id="selected_machine" class="font-medium text-blue-600">None</span></p>

                <div>
                    <label for="required_time" class="block mb-1 text-sm text-gray-600 dark:text-gray-300">Required Time:</label>
                    <select id="required_time" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="30">30 Minutes</option>
                        <option value="60">60 Minutes</option>
                        <option value="90">90 Minutes</option>
                        <option value="120">120 Minutes</option>
                    </select>
                </div>

                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Points:</strong> <span id="point_amount">-</span></p>
                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Total Price:</strong> <span id="total_price">RM0.00</span></p>

                <form action="{{ route('orders.store') }}" method="POST" class="pt-4">
                    @csrf
                    <input type="hidden" name="machine_id" id="machine_id">
                    <input type="hidden" name="required_time" id="required_time_input">
                    <input type="hidden" name="total_price" id="price_input">

                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded disabled:opacity-50"
                        id="checkout_btn" disabled>
                        ✅ Check-Out
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-10 text-center text-sm text-gray-600 dark:text-gray-400">
        📲 Scan the QR code on the laundry machine to earn points & track pricing.
    </div>
</div>
@endsection

@push('scripts')
<script>
    let selectedMachineId = null;
    const baseRate = 5.00;
    const countdownEnabled = true;

    const selectedMachineSpan = document.getElementById('selected_machine');
    const machineIdInput = document.getElementById('machine_id');
    const requiredTimeSelect = document.getElementById('required_time');
    const requiredTimeInput = document.getElementById('required_time_input');
    const priceInput = document.getElementById('price_input');
    const totalPriceDisplay = document.getElementById('total_price');
    const pointAmountDisplay = document.getElementById('point_amount');
    const checkoutBtn = document.getElementById('checkout_btn');

    function updateSummary() {
        const time = parseInt(requiredTimeSelect.value);
        const price = (time / 30) * baseRate;
        const points = (time / 30) * 50;

        requiredTimeInput.value = time;
        priceInput.value = price.toFixed(2);
        totalPriceDisplay.innerText = 'RM' + price.toFixed(2);
        pointAmountDisplay.innerText = points + ' pts';
    }

    document.querySelectorAll('.machine_select_btn').forEach(btn => {
        btn.addEventListener('click', function () {
            selectedMachineId = btn.dataset.machineId;
            selectedMachineSpan.innerText = 'Machine #' + selectedMachineId;
            machineIdInput.value = selectedMachineId;
            checkoutBtn.disabled = false;
            updateSummary();
        });
    });

    requiredTimeSelect.addEventListener('change', updateSummary);
    updateSummary();

    document.getElementById('type_filter').addEventListener('change', function () {
        const selectedType = this.value;
        document.querySelectorAll('.machine-row').forEach(row => {
            row.style.display = (selectedType === 'all' || row.dataset.type === selectedType) ? '' : 'none';
        });
    });

    if (countdownEnabled) {
        document.querySelectorAll('.countdown').forEach(span => {
            const endTime = new Date(span.dataset.endTime).getTime();
            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance <= 0) {
                    span.innerText = 'available';
                    span.classList.remove('text-yellow-500');
                    span.classList.add('text-green-500');
                    return;
                }

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                span.innerText = `${minutes}m ${seconds}s left`;
                setTimeout(updateCountdown, 1000);
            }

            updateCountdown();
        });
    }
</script>
@endpush
