@extends('layouts.app')
@section('content')

    <style>
        .bg-body-tertiary {
            background-color: rgba(245, 247, 250) !important;
        }
    </style>

    <main class="content-wrapper">
        <section class="pt-4 container">
            <div class="g-4 g-sm-3 g-md-4 row row-cols-lg-3 row-cols-sm-2 row-cols-1">
                @foreach ($categories as $category)
                    <div class="col">
                        <div class="card p-3"><p><a href="{{ route('help-topic', ['slug' => $category->slug]) }}">{{$category->name}}</a></p></div>
                    </div>
                @endforeach

            </div>
        </section>
    </main>
@endsection