@extends('layouts.app')

@section('title', __('Browse Cards'))

@section('jumbotron')
    <section class="jumbotron">
        <div class="container">
            <h1 class="jumbotron-heading">Search</h1>
            <form method="GET" action="{{ route('cards.index') }}">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <input type="text" class="form-control" id="keyword" name="keyword" value="{{ $request->input('keyword') }}" placeholder="Enter a keyword or card name..." autofocus>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select class="custom-select d-block w-100" id="collection" name="collection">
                            <option>Collection</option>
                            @foreach($collections as $collection)
                            <option value="{{ $collection->slug }}"{{ $collection->slug === $request->input('collection') ? ' selected' : '' }}>
                                {{ $collection->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="custom-select d-block w-100" id="format" name="format">
                            <option>Format</option>
                            @foreach($formats as $format)
                            <option value="{{ $format }}"{{ $format === $request->input('format') ? ' selected' : '' }}>
                                {{ $format }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button class="btn btn-primary btn-block" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @foreach($cards as $card)
            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <a href="{{ $card->url }}">
                    <img src="{{ $card->primary_image_url }}" alt="{{ $card->name }}" width="100%" />
                </a>
                <h6 class="card-title mt-3 mb-1">
                    <a href="{{ $card->url }}" class="font-weight-bold text-dark">
                        {{ $card->name }}
                    </a>
                </h6>
                <p class="card-text">
                    {{ __('Supply:') }} {{ number_format($card->token ? $card->token->supply_normalized : 0) }}
                    <span class="float-right d-none d-md-inline">{{ __('Collectors:') }} {{ $card->balances_count }}</span>
                </p>
            </div>
            @endforeach
        </div>
        {!! $cards->links() !!}
    </div>
@endsection