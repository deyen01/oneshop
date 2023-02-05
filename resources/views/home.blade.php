@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            @if(!isset($search))
            <section id="favproducts">
                <div class="d-block rounded-pill bga py-1 mt-4 text-center"><h2>Избранное</h2></div>
                <div class="justify-content-between card-group">
                @foreach($favproducts as $favproduct)
                    <a href="{{route('products.show',$favproduct->id)}}" class="card m-2 rounded-3 bga text-decoration-none link-dark" style="min-width: 240px">
                        @if($favproduct->picture) <img src="{{Storage::url($favproduct->picture->uri)}}" class="rounded-3 card-img-top"> @endif
                        <div class="card-body">
                            <div><b>{{$favproduct->title}}</b></div>
                        </div>
                    </a>
                @endforeach
                </div>
                @if (count($favproducts) > 1) {{ $favproducts->links() }} @endif
                @if(count($favproducts) < 1) Ничего нет в Избранном. @endif
            </section>
            <section id="popularcats">
                <div class="d-block rounded-pill bga py-1 mt-4 text-center"><h2>Популярные категории</h2></div>
                <div class="justify-content-between card-group">
                @foreach($popularcats as $popularcat)
                    <a href="{{route('categories.show',$popularcat->id)}}" class="card m-2 rounded-3 bga text-decoration-none link-dark" style="min-width: 240px">
                        @if($popularcat->picture) <img src="{{Storage::url($popularcat->picture->uri)}}" class="rounded-3 card-img-top"> @endif
                        <div class="card-body">
                            <div><b>{{$popularcat->title}}</b></div>
                        </div>
                    </a>
                @endforeach
                </div>
                @if (count($popularcats) > 1) {{ $popularcats->links() }} @endif
                @if(count($popularcats) < 1) Ничего нет в Популярных категориях. @endif
            </section>
            @endif
            <section id="search">
                <div class="d-block rounded-pill bga py-1 mt-4 text-center"><h2>Поиск</h2></div>
                <form class="mt-2" method="GET" action="{{ route('search') }}">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="search" name="search" maxlength="255" value="@if(isset($search)){{ $search }}@endif">
                        <label for="search" class="form-label">Название товара или категории</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Искать</button>
                </form>
            </section>
            @if(isset($search))
            <section id="search_results_products">
                <div class="d-block rounded-pill bga py-1 mt-4 text-center"><h2>Найденные товары</h2></div>
                <div class="justify-content-between card-group">
                @foreach($searchproducts as $searchproduct)
                    <a href="{{route('products.show',$searchproduct->id)}}" class="card m-2 rounded-3 bga text-decoration-none link-dark" style="min-width: 240px">
                        @if($searchproduct->picture) <img src="{{Storage::url($searchproduct->picture->uri)}}" class="rounded-3 card-img-top"> @endif
                        <div class="card-body">
                            <div><b>{{$searchproduct->title}}</b></div>
                        </div>
                    </a>
                @endforeach
                </div>
                @if (count($searchproducts) > 1) {{ $searchproducts->links() }} @endif
                @if(count($searchproducts) < 1) Не найдены товары по запросу. @endif
            </section>
            <section id="search_results_categories">
                <div class="d-block rounded-pill bga py-1 mt-4 text-center"><h2>Найденные категории</h2></div>
                <div class="justify-content-between card-group">
                @foreach($searchcats as $searchcat)
                    <a href="{{route('categories.show',$searchcat->id)}}" class="card m-2 rounded-3 bga text-decoration-none link-dark" style="min-width: 240px">
                        @if($searchcat->picture) <img src="{{Storage::url($searchcat->picture->uri)}}" class="rounded-3 card-img-top"> @endif
                        <div class="card-body">
                            <div><b>{{$searchcat->title}}</b></div>
                        </div>
                    </a>
                @endforeach
                </div>
                @if (count($searchcats) > 1) {{ $searchcats->links() }} @endif
                @if(count($searchcats) < 1) Не найдены категории по запросу. @endif
            </section>
            @endif
        </div>
    </div>
</div>
@endsection