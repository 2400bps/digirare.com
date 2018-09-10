@extends('layouts.app')

@section('title', 'Collectors')

@section('content')
    <div class="container mt-3">
        <div class="row mb-4">
            <div class="col">
                @include('collectors.partials.index.header')
                @include('collectors.partials.index.filter')
                @include('collectors.partials.index.table')
            </div>
        </div>
        @include('partials.featured')
    </div>
    @include('modals.featured')
@endsection