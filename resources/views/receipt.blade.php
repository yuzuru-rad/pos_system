<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>レシート発行</title>
    <style>
        /* CSS スタイルを追加してレシートのデザインを調整する */
        /* 以下はサンプルのスタイルであり、必要に応じてカスタマイズしてください */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .receipt {
            border: 1px solid #ccc;
            padding: 20px;
        }
        h1 {
            font-size: 24px;
            margin: 0;
        }
        h2{
            font-size: 18px;
            margin: 0;
        }
        h3{
            font-size:14px;
            margin-left: 100px;
        }
        p {
            margin: 10px 0;
        }

        @media print {
            body {
                font-size: 12px;
            }
            .receipt {
                width: 58mm; /* レシートプリンターの幅に合わせて調整 */
                padding: 5px;
            }
            .no-print{
                display: none;
            }
        }

    </style>
</head>
<body>

    <div class="receipt">
        <h1>デイリーヤマザキ</h1>
        
        <p>領収書</p>
        <p>日付: {{ now() }}</p>
        
        <hr>
        
        <h2>購入品目:</h2>
        <ul>
            @foreach(session('shoppingcart') as $item)
                <li>{{ $item->product_name }} × {{$item->amount}} --- {{ $item->taxinclude_price * $item->amount }}</li>
            @endforeach
        </ul>
        
        <hr>
        
        <h2>合 計: ￥{{ session('totalprice') }}</h2>
        <p>内税8.00%対象額: ￥{{ session('tax8rate') }}</p>
        <p>内税10.00%対象額: ￥{{ session('tax10rate') }}</p>
        <p>内消費税など: ￥{{ session('onlytax') }}</p>
        <hr>

        <p>お預かり: ￥{{ session('bill') }} </p>
        <p>お釣: ￥{{ session('change') }}</p>
        <hr>
        
        <p>お買い上げありがとうございます。</p>
    </div>
    <div class="container no-print">
        <div class="row">
            <div class="col s6">
                <button class="btn red waves-effect waves-light no-print" type="button" onClick="history.back()">キャンセル</button>
            </div>
            <div class="col s6">
                <form action="{{ route('wait') }}" method="GET">
                    <button class="btn green waves-effect waves-light no-print" type="submit">レジに戻る</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/materialize.min.js') }}"></script>
    
</body>
</html>
