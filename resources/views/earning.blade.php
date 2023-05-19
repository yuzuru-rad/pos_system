@extends('layouts.app')

@section('title', '売上照会')

@section('content')

    <div class="container">    
        <div class="row">
            <div class="col s12">
                <h2>お買い上げ品:</h2>
                <ul>
                    @foreach($earning as $item)
                        <li>{{ $item->product_name }} × {{$item->amount}} --- {{ $item->taxinclude_price * $item->amount }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    
        <div class="row">
            <div class="col s12">
                <h2>売上合計:</h2>
                <p>￥{{ $totalprice }}</p>
            </div>
        </div>
    
    <!-- いったん削除
        <div class="row">
            <div class="col s12">
                <form action="{{ route('basic') }}" method="GET">
                    <button class="btn green waves-effect waves-light" type="submit">レジに戻る</button>
                </form>
            </div>
        </div>
    -->
        <div class="row">
            <div class="col s12">
                <form action="{{ route('confirm-earnings') }}" method="GET">
                    <button class="btn red waves-effect waves-light" type="submit">売上確定</button>
                </form>
            </div>
        </div>
    </div>
        
@endsection

