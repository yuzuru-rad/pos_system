<!-- check.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>会計</title>
</head>
<body>
    <h1>会計</h1>
    
    <h2>お買い上げ品:</h2>
    <ul>
        @foreach($shoppingcart as $item)
            <li>{{ $item->product_name }} × {{$item->amount}} --- {{ $item->taxinclude_price * $item->amount }}</li>
        @endforeach
    </ul>
    
    <h2>合計:</h2>
    <p>￥{{ $totalprice }}</p>
    

    <form action="{{ route('process-payment') }}" method="post">
        @csrf
        <button type="submit">決定</button>
    </form>
</body>
</html>
