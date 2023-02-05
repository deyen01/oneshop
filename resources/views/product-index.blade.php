@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <dic class="col-3"><a type="button" class="btn btn-outline-primary my-8" href="{{ route('products.create') }}">Добавить товар</a></div>
        <div class="row justify-content-center">
        @foreach($products as $product)
            <div class="card col-3">
                @if($product->picture)<img src="{{ Storage::url($product->picture->uri) }}" class="card-img-top">@endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <a href="{{ route('products.show', $product); }}" class="btn btn-primary">Открыть</a>
                </div>
            </div>
        @endforeach
        </div>
        @if (count($products) > 1) {{ $products->links() }} @endif
        @if (count($products) < 1) Нет товаров. @endif
    </div>
</div>
@endsection