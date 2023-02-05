@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>Загрузка медиафайла</h3>
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
                <button type="submit" class="btn btn-primary">Загрузить</button>
            </form>
        </div>
    </div>
</div>
@endsection
