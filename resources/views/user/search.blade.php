@extends('user.layouts.base')

@section('title', 'Dashboard')

@section('content')
    <div class="container lg:pr-[70px] py-[50px] px-4 lg:pl-0 lg:ml-12">
        <h1>Search Results</h1>
        <p>Showing search results for: <strong>{{ $searchQuery }}</strong></p>

        @if ($goods->isEmpty())
            <p>No results found.</p>
        @else
            <ul>
                @foreach ($goods as $good)
                    <li>{{ $good->goods_name }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
