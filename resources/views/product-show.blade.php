@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                @if($product->picture)<img src="{{ Storage::url($product->picture->uri) }}" class="card-img-top">@endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    @if($product->favusers->contains(Auth::user()))<a href="{{ route('products.favdel', $product); }}" class="btn btn-primary">Убрать из Избранного</a>
                    @else<a href="{{ route('products.favadd', $product); }}" class="btn btn-primary">Добавить в Избранное</a>
                    @endif
                    <a href="{{ route('products.edit', $product); }}" class="btn btn-primary">Изменить</a>
                    <ul class="list-group list-group-flush">
                    @foreach($product->comments as $comment)
                        <li class="list-group-item">
                            {{ $comment->text }} {{ $comment->grade }}
                            <form class="mt-2" action="{{ route('comments.destroy', $comment) }}" method="POST">@csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-outline-danger">Удалить</button>
                            </form>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <form class="mt-2" method="POST" action="{{ route('products.comments.store', $product) }}">@csrf
                <div class="mb-3">
                    <input type="text" class="form-control" id="text" name="text" maxlength="255">
                    <label for="text" class="form-label">Текст комментария</label>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" id="grade" min="0" max="5" step="1" name="grade">
                    <label for="grade" class="form-label">Оценка (от 0 до 5)</label>
                </div>
                <button type="submit" class="btn btn-primary">Добавить отзыв</button>
            </form>
        </div>
    </div>
</div>
@endsection