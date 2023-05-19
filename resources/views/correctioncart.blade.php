@extends('layouts.app')

@section('content')
    <h3 class="center-align">買い物修正</h3>

    <div class="row">
        <form id="updateForm" class="col s12" action="{{ route('updatecart', ['id' => $cartItem->id]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" id="product_name" name="product_name" value="{{ $cartItem->product_name }}" readonly>
                    <label for="product_name">商品名</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input type="number" id="amount" name="amount" value="{{ $cartItem->amount }}">
                    <label for="amount">数量</label>
                </div>
            </div>
            <div class="row">
                <div class="col s2">
                    <button class="btn waves-effect waves-light" type="submit">更新</button>
                </div>
            </div>
        </form>

        <form id="deleteForm" class="col s12" action="{{ route('deletecart', ['id' => $cartItem->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="row">
                <div class="col s2">
                    <button class="btn waves-effect waves-light red" type="submit">削除</button>
                </div>
            </div>
        </form>
    </div>
@endsection
