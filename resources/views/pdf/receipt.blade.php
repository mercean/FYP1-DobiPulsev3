<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DobiPulse Receipt</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 30px;
        }

        .container {
            width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .footer {
            font-size: 11px;
            color: #777;
            text-align: center;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>DobiPulse Receipt</h2>
            <p>Order ID: <strong>{{ $order->order_number ?? 'ORD-' . $order->id }}</strong></p>
            <p>Date: {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>

        <div class="section">
            <div class="section-title">Order Summary</div>
            <div class="row"><span>Status:</span><span>{{ ucfirst($order->status) }}</span></div>
            <div class="row"><span>Type:</span><span>{{ $order->type }}</span></div>
            <div class="row"><span>Total Price:</span><span>RM {{ number_format($order->total_amount, 2) }}</span></div>
            <div class="row"><span>Loyalty Points:</span><span>{{ $userPoints }} pts</span></div>
        </div>

        @if ($order->machine)
        <div class="section">
            <div class="section-title">Machine Details</div>
            <div class="row"><span>Machine #:</span><span>{{ $order->machine->id }}</span></div>
            <div class="row"><span>Type:</span><span>{{ ucfirst($order->machine->type) }}</span></div>
            <div class="row"><span>Location:</span><span>{{ $order->machine->location }}</span></div>
        </div>
        @endif

        <div class="footer">
            Thank you for choosing DobiPulse. Contact us via WhatsApp if you need assistance.
        </div>
    </div>
</body>
</html>
