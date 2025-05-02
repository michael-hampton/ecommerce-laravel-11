@extends('layouts.app')
@section('content')

    <style>
       .category-item .card:hover {
            background-color: #eee;
       }
    </style>

    <main class="content-wrapper">
        <section class="pt-4 container">
            <div class="g-4 g-sm-3 g-md-4 row row-cols-lg-3 row-cols-sm-2 row-cols-1">
                @foreach ($categories as $category)
                    <div class="col-2 category-item">
                        <div class="card p-3">
                            <p class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('help-topic', ['slug' => $category->slug]) }}">
                                    {{$category->name}}
                                </a>
                                @if(!empty($category->icon))
                                <i style="    font-size: 25px; line-height: 32px;" class="fa {{ $category->icon }}"></i>
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </section>
    </main>
@endsection