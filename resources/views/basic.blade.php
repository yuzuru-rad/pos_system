@extends('layouts.app')

@section('title', 'レジ機能')

@section('content')

    <h1>Waiting...</h1>
    <form id="barcode-form" action="{{ route('search') }}" method="POST">
        @csrf
        <input id="barcode-input" type="number" name="barcode" autofocus>
    </form>
<!-- いったん削除
    <form action="{{ route('show-earnings') }}" method="GET">
        <button class="btn greeen waves-effect waves-light" type="submit">売上照会</button>
    </form>
-->
    <script>
    // バーコードリーダーからの値を受け取るイベントリスナー
        document.addEventListener('keypress', function (event) {
        // キーコードがバーコードリーダーの値に対応している場合のみ処理を実行
        // 例: Enterキーをバーコードリーダーの終了キーコードとして使用する場合
        if (event.keyCode === 13) {
            // バーコードの値を取得してフォームに設定し、検索処理を実行
            document.getElementById('barcode-input').focus();
            const barcodeValue = event.target.value;

            document.getElementById('barcode-input').value = barcodeValue;
            document.getElementById('barcode-form').submit();
        }
    });
    </script>
    
@endsection
