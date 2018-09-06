@extends('layouts.app')

@section('title', 'Big Board')

@section('content')
    <div class="container mt-3">
        <div class="row mb-4">
            <div class="col">
                <h1 class="display-4 mb-4">
                    <small class="text-highlight"><i aria-hidden="true" class="fa fa-list"></i></small>
                    Big Board
                </h1>
                <ul class="nav nav-tabs border-bottom-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Action</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item{{ $request->input('action', null) === null ? ' active' : '' }}" href="{{ route('orders.index', ['action' => null, 'collection' => $request->input('collection', null), 'currency' => $request->input('currency', null)]) }}">All</a>
                            <a class="dropdown-item{{ $request->input('action', null) === 'buying' ? ' active' : '' }}" href="{{ route('orders.index', ['action' => 'buying', 'collection' => $request->input('collection', null), 'currency' => $request->input('currency', null)]) }}">Buying</a>
                            <a class="dropdown-item{{ $request->input('action', null) === 'selling' ? ' active' : '' }}" href="{{ route('orders.index', ['action' => 'selling', 'collection' => $request->input('collection', null), 'currency' => $request->input('currency', null)]) }}">Selling</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Collections</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item{{ $request->input('collection', null) === null ? ' active' : '' }}" href="{{ route('orders.index', ['collection' => null, 'currency' => $request->input('currency', null), 'action' => $request->input('action', null)]) }}">All</a>
                        @foreach($collections as $collection)
                            <a class="dropdown-item{{ $collection->slug === $request->input('collection', null) ? ' active' : '' }}" href="{{ route('orders.index', ['collection' => $collection->slug, 'currency' => $request->input('currency', null), 'action' => $request->input('action', null)]) }}">{{ $collection->name }}</a>
                        @endforeach
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Currencies</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item{{ $request->input('currency', null) === null ? ' active' : '' }}" href="{{ route('orders.index', ['currency' => null, 'collection' => $request->input('collection', null), 'action' => $request->input('action', null)]) }}">All</a>
                        @foreach($currencies as $currency)
                            <a class="dropdown-item{{ $currency === $request->input('currency', null) ? ' active' : '' }}" href="{{ route('orders.index', ['currency' => $currency, 'collection' => $request->input('collection', null), 'action' => $request->input('action', null)]) }}">{{ $currency }}</a>
                        @endforeach
                        </div>
                    </li>
                </ul>
                <div class="card mb-4">
                    <div class="card-header">
                        <span class="lead font-weight-bold">
                            List View
                        </span>
                    </div>
                    @include('orders.partials.table')
                </div>
            </div>
        </div>
    </div>
@endsection