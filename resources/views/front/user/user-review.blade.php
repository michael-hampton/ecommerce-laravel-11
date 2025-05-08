@php use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.app')
@section('content')
    <div>
        <div class="container" style="padding: 30px 0">
            <div class="product-single__review-form">
                @include('front.user.partials.review-form')
            </div>
        </div>
    </div>
@endsection



