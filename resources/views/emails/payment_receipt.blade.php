<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
</head>
<body>
    <h2>Hello {{ $order->user->name }},</h2>
    <p>Thank you for your payment. Here is your receipt:</p>
    <ul>
        <li><strong>Order ID:</strong> #{{ $order->id }}</li>
        <li><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</li>
        <li><strong>Machine ID:</strong> {{ $order->machine_id }}</li>
        <li><strong>Required Time:</strong> {{ $order->required_time }} minutes</li>
        <li><strong>Total Paid:</strong> RM{{ number_format($order->final_price ?? $order->total_amount, 2) }}</li>
        <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
    </ul>
    <p>We appreciate your business!</p>
    <p>— DobiPulse Team</p>
</body>
</html>
