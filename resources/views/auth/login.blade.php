@extends('layouts.app')

@section('content')
    <style>
        .form-outline {
            position: relative;
            width: 100%;
        }
    </style>
    <div class="container pt-90">
        <div class="mb-4 pb-4">
            <form method="POST" action="{{route('login.authenticate')}}" name="login-form" class="needs-validation" novalidate="">
                @csrf
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input name="email" type="email" id="form2Example1"
                           class="form-control @error('email') is-invalid @enderror"/>
                    <label class="form-label" for="form2Example1">Email address</label>
                    @error('email')
                    <span class="invalid-feedback" readonly="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                    @enderror
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form2Example2"
                           class="form-control @error('password') is-invalid @enderror" name="password"/>
                    <label class="form-label" for="form2Example2">Password</label>
                    @error('password')
                    <span class="invalid-feedback" readonly="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                    @enderror
                </div>

                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">
                    <div class="col d-flex justify-content-center">
                        <!-- Checkbox -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked/>
                            <label class="form-check-label" for="form2Example31"> Remember me </label>
                        </div>
                    </div>

                    <div class="col">
                        <!-- Simple link -->
                        <a href="#!">Forgot password?</a>
                    </div>
                </div>

                <!-- Submit button -->
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                    Sign in
                </button>

                <!-- Register buttons -->
                <div class="text-center">
                    <p>Not a member? <a href="{{route('register')}}">Register</a></p>
                </div>
            </form>
        </div>
    </div>
    </
@endsection
