@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <section id="sortproducts" class="w-100">
            <div class="d-block rounded-pill bga py-1 mt-4 text-center"><h2>Сортировка товаров</h2></div>
            <form class="mt-2 row justify-content-center" method="GET" action="{{ route('categories.show', $category) }}">
                <div class="mb-3 col-4">
                    <select id="sort_by_date" name="sort_by_date" class="form-select">
                        <option value="0" @if($sort_by_date == 0) selected @endif >Не сортировать</option>
                        <option value="1" @if($sort_by_date == 1) selected @endif >По убыванию</option>
                        <option value="2" @if($sort_by_date == 2) selected @endif >По возрастанию</option>
                    </select>
                    <label for="sort_by_date" class="form-label">По дате</label>
                </div>
                <div class="mb-3 col-4">
                    <select id="sort_by_comments" name="sort_by_comments" class="form-select">
                        <option value="0" @if($sort_by_comments == 0) selected @endif >Не сортировать</option>
                        <option value="1" @if($sort_by_comments == 1) selected @endif >По убыванию</option>
                        <option value="2" @if($sort_by_comments == 2) selected @endif >По возрастанию</option>
                    </select>
                    <label for="sort_by_comments" class="form-label">По кол-ву отзывов</label>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Сортировать</button>
            </form>
        </section>
        <div class="w-100">
            <div class="card">
                @if($category->picture)<img src="{{ Storage::url($category->picture->uri) }}" class="card-img-top">@endif
                <div class="card-body">
                    <h5 class="card-title">{{ $category->title }}</h5>
                    <a href="{{ route('categories.edit', $category); }}" class="btn btn-primary">Изменить</a>
                </div>
            </div>
        </div>
        <section id="products" class="w-100">
            <div class="d-block rounded-pill bga py-1 mt-4 text-center"><h2>Товары</h2></div>
            <div class="row justify-content-center">
            @foreach($products as $product)
                <div class="card col-4">
                    @if($product->picture)<img src="{{ Storage::url($product->picture->uri) }}" class="card-img-top">@endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <a href="{{ route('products.show', $product); }}" class="btn btn-primary">Открыть</a>
                    </div>
                </div>
            @endforeach
            </div>
        </section>
        @if (count($products) > 1) {{ $products->links() }} @endif
        @if (count($products) < 1) Нет товаров. @endif
    </div>
</div>
@endsection