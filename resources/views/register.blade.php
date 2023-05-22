@extends('layouts.app')

@section('title', '商品登録')

@section('content')  
    <div class="container">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="card-panel red lighten-2 white-text">
                {{ session('flash_message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('product.register') }}">
            @csrf

            <div class="input-field">
                <label for="product_name">商品名:</label>
                <input type="text" id="product_name" name="product_name" required>
            </div>

            <div class="input-field">
                <label for="product_code">バーコードNO:</label>
                <input type="number" id="product_code" name="product_code" required>
            </div>

            <div class="input-field">
                <label for="price">定価:</label>
                <input type="number" id="price" name="price" required>
            </div>

            <div class="input-field">
                <select id="taxrate" name="taxrate" required>
                    <option value="0.08">0.08</option>
                    <option value="0.10">0.10</option>
                </select>
                <label for="taxrate">税率:</label>
            </div>

            <div class="input-field">
                <label for="taxinclude_price">税込み価格:</label>
                <input type="number" id="taxinclude_price" name="taxinclude_price" required>
            </div>

            <button class="btn greeen waves-effect waves-light" type="submit">登録</button>
        </form>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('select').formSelect();
        });
    </script>
@endsection