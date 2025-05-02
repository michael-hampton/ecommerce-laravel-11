@extends('layouts.app')
@section('content')
    <main class="content-wrapper">
        <section class="pt-3 pt-sm-4 container">
            <div class="accordion" id="accordionExample">
                @foreach($questions as $question)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#parent-{{$question->id}}" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                {{$question->question}}
                            </button>
                        </h2>
                        <div id="parent-{{$question->id}}" class="accordion-collapse collapse"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {{ $question->answer }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
                
        </section>
    </main>
@endsection