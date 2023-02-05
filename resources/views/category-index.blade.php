@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <dic class="col-3"><a type="button" class="btn btn-outline-primary my-8" href="{{ route('categories.create') }}">Добавить категорию</a></div>
        <div class="row justify-content-center">
        @foreach($categories as $category)
            <div class="card col-3">
                @if($category->picture)<img src="{{ Storage::url($category->picture->uri) }}" class="card-img-top">@endif
                <div class="card-body">
                    <h5 class="card-title">{{ $category->title }}</h5>
                    <a href="{{ route('categories.show', $category); }}" class="btn btn-primary">Открыть</a>
                </div>
            </div>
        @endforeach
        </div>
        @if (count($categories) > 1) {{ $categories->links() }} @endif
        @if (count($categories) < 1) Нет категорий. @endif
    </div>
</div>
@endsection