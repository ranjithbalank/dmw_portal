@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 py-6" style="margin-top: 100px;">
                <div class="card">
                    <div class="card-header d-flex justify-content-center align-items-center"
                        style="background:#FC5C14; color: white;font-size:150%"><b>{{ 'MyDMW Login Dev ' }}</b></div>

                    <div class="card-body">
                        {{-- Logo --}}
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="My DMW Portal Logo" class="img-fluid mb-2"
                                style="max-height: 140px;">
                        </div>


                        {{-- Login Form --}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ 'Email Address' }}
                                    <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end"> {{ 'Password' }} <span
                                        class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                    <div class="card-footer bg-light text-end ">
                        <button type="submit" class="btn btn-primary px-5">
                            {{ 'Login' }}
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
