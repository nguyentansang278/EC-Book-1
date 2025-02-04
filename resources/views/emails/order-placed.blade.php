<!DOCTYPE html>
<html>
<head>
    <title>Order placed</title>
</head>
<body>
    <h1>Thank you for shopping with us!</h1>
    <p>Hello {{ $order->user->name }},</p>
    <p>We have received your order. Here are the details:</p>
    
    <ul>
        <li>Order ID: #{{ $order->id }}</li>
        <li>Date: {{ $order->created_at }}</li>
        <li>Total amount: ${{ $order->total_price }}</li>
    </ul>

    <p>Order details:</p>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->book->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ $item->price }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Shipping fee</td>
                <td></td>
                <td>$5</td>
            </tr>
        </tbody>
    </table>

    <p>Track your order <a class="" href="{{ route('client.orders.show', ['id' => $order->id]) }}">here</a>.</p>
    

    <p>If you have any questions, please <a href="{{ route('contact') }}">contact us</a>.</p>
</body>
</html>
