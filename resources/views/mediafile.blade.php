@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
        <a type="button" class="btn btn-outline-primary my-8" href="{{ route('mediafiles.create') }}">Добавить медиафайл</a>
        @foreach ($mediafiles as $mediafile)
            <div class="card my-4">
                <div class="card-header"><a href="{{ route('mediafiles.show', $mediafile) }}">{{ $mediafile->id }}</a> Автор: {{ $mediafile->user->name }} Создано: {{ date_format(date_create($mediafile->created_at), 'd.m.Y H:i:s') }}, изменён {{ date_format(date_create($mediafile->updated_at), 'd.m.Y H:i:s') }}.</div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Контрольная сумма SHA-256</dt>
                        <dd class="col-sm-9">{{ bin2hex($mediafile->sha256checksum) }}</dd>
                        <dt class="col-sm-3">URI</dt>
                        <dd class="col-sm-9"><a target="_blank" href="{{ Storage::url($mediafile->uri) }}">{{ Storage::url($mediafile->uri) }}</a></dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <form action="{{ route('mediafiles.destroy', $mediafile) }}" method="POST">@csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-outline-danger">Удалить</button>
                    </form>
                </div>
            </div>
        @endforeach
        @if (count($mediafiles) > 1) {{ $mediafiles->links() }} @endif
        @if (count($mediafiles) < 1) Нет медиафайлов. @endif
        </div>
    </div>
</div>
@endsection
