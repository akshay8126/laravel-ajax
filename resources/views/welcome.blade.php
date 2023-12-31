@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>
                    <div id="errors-list"></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" id="login">
                            @csrf
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert" id="emailerror">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

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

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="button">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#login").on("submit", function(e) {
                e.preventDefault();
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                //     }
                // });
                // var formData = {
                //     'email': $("#email").val(),
                //     'password': $("#password").val(),
                //     "_token": '{{ csrf_token() }}',
                // };
                var formData = $("#login").serialize();
                console.log(formData);
                $("#button").html("Login ...");
                $.ajax({
                    url: $(this).attr('action'), //'{{ route('login') }}',
                    type: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $("#errors-list").append(
                            "<div class='alert alert-success'>" + data.message +
                            "</div>");
                        window.location.replace(data.data)

                    },
                    error: function(data) {
                        $.each(data.responseJSON.message, function(key, val) {
                            $("#errors-list").append(
                                "<div class='alert alert-danger'>" + val +
                                "</div>");
                        });
                        setTimeout(() => {
                            $("#errors-list").empty();
                        }, 1000);
                    }
                });
            });
        });
    </script>
@endsection
