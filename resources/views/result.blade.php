@extends('layouts.app')

@section('title', 'レジ機能')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col s12">
                @if($products)
                    <p>商品名: {{ $products->product_name }}</p>
                    <p>価格: {{ $products->taxinclude_price }}</p>
                @else
                    <p>商品が見つかりませんでした。</p>
                @endif
            </div>
        </div>
    
        <div class="row">
            <div class="col s12">
                <form id="barcode-form" action="{{ route('search') }}" method="POST">
                    @csrf
                    <input id="barcode-input" type="number" name="barcode" autofocus>
                </form>
            </div>
        </div>
    
        <div class="row">
            <div class="col s12">
                <h3>お買い上げ品:</h3>
                <ul>
                    @foreach($shoppingcart as $item)
                        <li>{{ $item->product_name }} × {{$item->amount}} --- {{ $item->taxinclude_price * $item->amount }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    
        <div class="row">
            <div class="col s12">
                <h3>合計:</h3>
                <p>￥{{ $totalprice }}</p>
            </div>
        </div>
    
        <div class="row">
            <div class="input-field col s4">
                <form id="bills" action="{{ route('process-payment') }}" method="POST">
                    @csrf
                    <input id="bills" type="number" name="bill" required>
                </form>
            </div>
            <div class="input-field col s8">
                <button id="bills" form="bills" class="btn green waves-effect waves-light" type="submit">お支払い</button>
            </div>
        </div>
        <div class="row">
            <div class="col s8 offset-s4">
                <form action="{{ route('showcart') }}" method="GET">
                    @csrf
                    <button class="btn red waves-effect waves-light" type="submit">修正</button>
                </form>
            </div>
        </div>
    </div>
        <script>
        // バーコードリーダーからの値を受け取るイベントリスナー
        document.addEventListener('keypress', function (event) {
            // キーコードがバーコードリーダーの値に対応している場合のみ処理を実行
            // 例: Enterキーをバーコードリーダーの終了キーコードとして使用する場合
            if (event.keyCode === 13) {
                // バーコードの値を取得してフォームに設定し、検索処理を実行
                document.getElementById('barcode-input').focus();
                const barcodeValue = event.target.value;
                //console.log('Barcode value: ' + barcodeValue);

/*            const convertedBarcode = barcodeValue.replace(/[０-９]/g, function (s) {
                return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
            });
*/
                //console.log('Barcode value: ' + convertedBarcode);
                document.getElementById('barcode-input').value = convertedBarcode;
                document.getElementById('barcode-form').submit();
            }
        });
    </script>
@endsection