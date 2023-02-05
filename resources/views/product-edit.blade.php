@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <h3>@if ($edit == 1) Изменение @else Создание @endif товара</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="mt-2" method="POST" action="@if($edit == 1){{ route('products.update', $product) }}@else{{ route('products.store') }}@endif">@csrf
                <div class="mb-3">
                    <input type="text" class="form-control" id="title" name="title" maxlength="255" value="{{ $product->title }}">
                    <label for="title" class="form-label">Название</label>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" id="price" min="0" name="price" value="{{ $product->price }}">
                    <label for="price" class="form-label">Цена</label>
                </div>
                <div class="mb-3">
                    <select id="category_id" name="category_id" class="form-select">
                    @foreach ($categories as $selcat)
                        <option value="{{ $selcat->id }}" @if($product->category_id == $selcat->id) selected @endif >{{ $selcat->title }}</option>
                    @endforeach
                    </select>
                    <label for="type" class="form-label">Категория</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="setpicture" id="setpicture" name="setpicture">
                    <label class="form-check-label" for="setpicture">Задать картинку</label>
                </div>
                @if($edit == 1)<input type="hidden" name="_method" value="PATCH">@endif
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
            @if($edit == 1)
            <form class="mt-2" action="{{ route('products.destroy', $product) }}" method="POST">@csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-outline-danger">Удалить</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection