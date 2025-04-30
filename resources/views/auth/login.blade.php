@extends('layouts.app')

@section('content')
    <style>
        .form-outline {
            position: relative;
            width: 100%;
        }
        @media (min-width: 1025px) {
.h-custom {
height: 100vh !important;
}
}
.card-registration .select-input.form-control[readonly]:not([disabled]) {
font-size: 1rem;
line-height: 2.15;
padding-left: .75em;
padding-right: .75em;
}
.card-registration .select-arrow {
top: 13px;
}


@media (min-width: 992px) {
.card-registration-2 .bg-indigo {
border-top-right-radius: 15px;
border-bottom-right-radius: 15px;
}
}
@media (max-width: 991px) {
.card-registration-2 .bg-indigo {
border-bottom-left-radius: 15px;
border-bottom-right-radius: 15px;
}
}
    </style>
    <section class="h-100 h-custom gradient-custom-2">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
              <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                <div class="card-body p-0">
                  <div class="row g-0">
                    <div class="col-lg-6">
                      <div class="p-5">
                        <h3 class="fw-normal mb-5" style="color: #4835d4;">Login</h3>
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
                                    <a href="{{ route('password.request') }}">Forgot password?</a>
                                </div>
                            </div>
            
                            <!-- Submit button -->
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                                Sign in
                            </button>
            
                            <!-- Register buttons -->
                            {{-- <div class="text-center">
                                <p>Not a member? <a href="{{route('register')}}">Register</a></p>
                            </div> --}}
                        </form>
                      </div>
      
                    </div>
                    <div class="col-lg-6">
                      <div class="p-5">
                        <h3 class="fw-normal mb-5">Register</h3>
                        <form method="POST" action="{{route('register')}}" name="register-form" class="needs-validation"
                              novalidate="">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control form-control_gray  @error('name') is-invalid @enderror"
                                       name="name" value="{{old('name')}}" required="" autocomplete="name"
                                       autofocus="">
                                <label for="name">Name</label>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="pb-3"></div>
                            <div class="form-floating mb-3">
                                <input id="email" type="email"
                                       class="form-control form-control_gray  @error('email') is-invalid @enderror"
                                       name="email" value="{{old('email')}}" required=""
                                       autocomplete="email">
                                <label for="email">Email address *</label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="pb-3"></div>

                            <div class="form-floating mb-3">
                                <input id="mobile" type="text"
                                       class="form-control form-control_gray  @error('mobile') is-invalid @enderror"
                                       name="mobile" value="{{old('mobile')}}"
                                       required="" autocomplete="mobile">
                                <label for="mobile">Mobile *</label>
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="pb-3"></div>

                            <div class="form-floating mb-3">
                                <input id="password" type="password"
                                       class="form-control form-control_gray  @error('password') is-invalid @enderror"
                                       name="password" required=""
                                       autocomplete="new-password">
                                <label for="password">Password *</label>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input id="password-confirm" type="password" class="form-control form-control_gray"
                                       name="password_confirmation" required="" autocomplete="new-password">
                                <label for="password">Confirm Password *</label>
                            </div>

                            <div class="d-flex align-items-center mb-3 pb-2">
                                <p class="m-0">Your personal data will be used to support your experience throughout
                                    this website, to
                                    manage access to your account, and for other purposes described in our privacy
                                    policy.</p>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="seller_account">
                                <label class="form-check-label" for="flexCheckDefault">
                                  Create seller account (allows you to sell products)
                                </label>
                              </div>

                            <button class="btn btn-primary w-100 text-uppercase" type="submit">Register</button>

                            <div class="customer-option mt-4 text-center">
                                <span class="text-secondary">Have an account?</span>
                                <a href="{{route('login')}}" class="btn-text js-show-register">Login to your Account</a>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection
