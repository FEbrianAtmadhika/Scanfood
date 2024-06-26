@extends('FrontPage.layout.app')

@section('title', 'Register')

@section('main_content')
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">

              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">

                  <div class="text-center">
                    <h4 class="mt-1 mb-5 pb-1">Register</h4>
                  </div>

                  <form method="POST" action="{{ route('register_submit') }}">
                    @csrf
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="form2Example11">Nama</label>
                      <input type="text" id="name" class="form-control" name="name"
                        placeholder="Nama" />

                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="form2Example11">Email</label>
                      <input type="email" id="email" class="form-control" name="email"
                        placeholder="Email" />

                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">

                      <label class="form-label" for="form2Example22">Password</label>
                      <input type="password" id="password" name="password" class="form-control" />
                    </div>

                    <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                      <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg mb-3" type="submit" >Register</button>
                    </div>

                    <div class="d-flex align-items-center justify-content-center pb-4">
                      <p class="mb-0 me-2">Already Have Account?</p>
                      <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
                    </div>

                  </form>

                </div>
              </div>
              <div class="col-lg-6 d-flex login_background">
                <div>
                    <img src="{{ asset('img/sidepicregister.png') }}" class="img-fluid">
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
