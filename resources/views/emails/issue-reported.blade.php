<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Issue Reported</title>
</head>

<body>
    <p>Hi {{$mailData['item']->seller->name}}</p>
    <p>Order #{{$mailData['item']->order_id}}
    Customer {{ $mailData['customer'] }}
    </p>

    <p>Message From Buyer: {{ $mailData['message'] }} </p>
    <p>Requested Resolution: {{ $mailData['resolution'] }} </p>


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
            <tr>
                <td><img src="{{asset('images/products')}}/{{$mailData['item']->product->image}}" width="100"
                        alt="{{$mailData['item']->product->name}}" /></td>
                <td>{{$mailData['item']->product->name}}</td>
                <td>{{$mailData['item']->quantity}}</td>
                <td>{{$mailData['currency']}}{{$mailData['item']->price * $mailData['item']->quantity}}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>