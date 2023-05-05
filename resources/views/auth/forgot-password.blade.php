@extends('auth.auth_master')
@section('auth')
<section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
            class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

          <form method="POST" action="{{ route('password.email') }}"> @csrf
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                Enter Your <strong>E-mail</strong> and instructions will be sent to you!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-info" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
              {{-- <p class="lead fw-normal mb-0 me-3">Recover Password</p> --}}

            </div>

            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">Recover Password</p>
              <a class="text-primary" href="{{route('home')}}">Home Page</a>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="form3Example3" name="email" required autofocus class="form-control form-control-lg"
                placeholder="Enter a valid email address" />
              <label class="form-label" for="form3Example3">Email address</label>
            </div>


            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Send Email</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Remember Password ? <a href="{{route('login')}}"
                  class="link-danger">Login</a></p>
            </div>

          </form>
        </div>
      </div>
    </div>
    <div
      class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
      <!-- Copyright -->
      <div class="text-white mb-3 mb-md-0">
        Copyright © 2020. All rights reserved.
      </div>
      <!-- Copyright -->

      <!-- Right -->

      <!-- Right -->
    </div>
  </section>
@endsection
