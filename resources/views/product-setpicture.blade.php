@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>Загрузка картинки для товара {{ $product->title }}</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="mt-2" enctype="multipart/form-data" method="POST" action="{{ route('mediafiles.store') }}">@csrf
                <div class="mb-3">
                    <input type="file" class="form-control" id="mediafile" name="mediafile" accept="video/mp4,video/x-matroska,video/webm,image/jpeg,image/png,image/webp,application/pdf,application/x-pdf" required>
                    <label for="mediafile" class="form-label">Медиафайл</label>
                </div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-primary">Загрузить</button>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>Или выберите существующую картинку для товара {{ $product->title }}</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (count($mediafiles) > 0)
            <form class="mt-2" enctype="multipart/form-data" method="POST" action="{{ route('mediafiles.attach') }}">@csrf
                @foreach ($mediafiles as $mediafile)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="picture_id" id="picture_id-{{ $mediafile->id }}" value="{{ $mediafile->id }}">
                    <label class="form-check-label" for="picture_id-{{ $mediafile->id }}">{{ $mediafile->id }}<img src="{{ Storage::url($mediafile->uri) }}" width="300"></label>
                </div>
                @endforeach
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-primary">Выбрать</button>
            </form>
            @endif
            @if (count($mediafiles) > 1) {{ $mediafiles->links() }} @endif
            @if(count($mediafiles) < 1) Нет медиафайлов для выбора. @endif
        </div>
    </div>
</div>
@endsection