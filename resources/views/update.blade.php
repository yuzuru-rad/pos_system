@extends('layouts.app')

@section('title', '商品更新')

@section('content')
    <div class="container">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="card-panel red lighten-2 white-text">
                {{ session('flash_message') }}
            </div>
        @endif

        <h2>データ重複があります、入力内容で更新しますか？更新する場合は更新ボタンを押してください。</h2>

        <form method="POST" action="{{ route('product.update') }}"  id="update-form">
            @csrf

            <div class="input-field">
                <label for="product_name">商品名:</label>
                <input type="text" id="product_name" name="product_name" value={{ $product_name }} required>
            </div>

            <div class="input-field">
                <label for="product_code">バーコードNO:</label>
                <input type="number" id="product_code" name="product_code" value={{ $product_code }} required>
            </div>

            <div class="input-field">
                <label for="price">定価:</label>
                <input type="number" id="price" name="price" value={{ $price }} required>
            </div>

            <div class="input-field">
                <label for="taxrate">税率:</label>
                <input type="number" id="price" name="taxrate" value={{ $taxrate }} required>
            </div>

            <div class="input-field">
                <label for="taxinclude_price">税込み価格:</label>
                <input type="number" id="taxinclude_price" name="taxinclude_price" value={{ $taxinclude_price }} required>
            </div>
        </form>
        <div style="display: flex; justify-content: space-between;">
            <button form="update-form" class="btn green waves-effect waves-light" type="submit">更新</button>

            <form method="GET" action="{{ route('product.cansel') }}" >
                @csrf
                <button class="btn red waves-effect waves-light" type="submit">キャンセル</button>
            </form>
        </div>
    <script>
        $(document).ready(function() {
            $('select').formSelect();
        });
    </script>
@endsection
