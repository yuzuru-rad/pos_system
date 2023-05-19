@extends('layouts.app')

@section('content')
    <h3>買い物修正</h3>
    <p>修正したい項目を選んでタップしてください</p>

    <ul>
        @foreach($shoppingcart as $item)
            <li style="margin-top:30px; margin-bottom:30px; font-size: 18px;">
                <a href="{{ route('correctioncart', ['id' => $item->id]) }}">
                    {{ $item->product_name }} --- 数量: {{$item->amount}}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="row">
        <div class="col s12">
            <form action="{{ route('result2') }}" method="GET">
                @csrf
                <button class="btn green waves-effect waves-light" type="submit">買い物に戻る</button>
            </form>
        </div>
    </div>

@endsection
