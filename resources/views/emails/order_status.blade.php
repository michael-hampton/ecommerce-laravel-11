<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmation</title>
</head>
<body>
<p>Hi {{$order->customer->name}}</p>
<p>Your order #{{$order->id}} status has been updated to {{$order->status}}</p>
<table style="width: 600px; text-align:right">
    <thead>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orderItems as $item)
        <tr>
            <td><img src="{{asset('images/products')}}/{{$item->product->image}}" width="100" alt="{{$item->product->name}}" /></td>
            <td>{{$item->product->name}}</td>
            <td>{{$item->quantity}}</td>
            <td>{{$currency}}{{$item->price * $item->quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3" style="border-top:1px solid #ccc;"></td>
        <td style="font-size:15px;font-weight:bold;border-top:1px solid #ccc;">Subtotal : {{$currency}}{{$order->subtotal}}</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td  style="font-size:15px;font-weight:bold;">Tax : {{$currency}}{{$order->tax}}</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td  style="font-size:15px;font-weight:bold;">Shipping : {{$currency}}{{$order->shipping}}/td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td  style="font-size:15px;font-weight:bold;">Commission : {{$currency}}{{$order->commission}}/td>
    </tr>

    <tr>
        <td colspan="3"></td>
        <td  style="font-size:15px;font-weight:bold;">Discount : {{$currency}}{{$order->discount}}/td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td style="font-size:22px;font-weight:bold;">Total : {{$currency}}{{$order->total}}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
