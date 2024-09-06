<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <link href="{{global_asset('admin_assets\css\styles.css')}}" rel="stylesheet" />

        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">{{ __(' Tenent Register') }}</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ url('/tenant_show') }}">

                                            @csrf


                                                 <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input id="inputFirstName"  type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror





                                                        {{-- <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" /> --}}
                                                        <label for="inputFirstName">Name </label>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-floating mb-3">
                                                <input id="inputdomain" type="text" class="form-control @error('domain_name') is-invalid @enderror" name="domain_name" value="{{ old('domain_name') }}" required autocomplete="domain_name">

                                                @error('domain_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror



                                                {{-- <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" /> --}}
                                                <label for="inputEmail">Business Name Domain </label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input id="inputEmail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror



                                                {{-- <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" /> --}}
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                  
                                                        <input id="inputPassword"  type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                  
                                                  
                                                        {{-- <input class="form-control" id="inputPassword" type="password" placeholder="Create a password" /> --}}
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input id="inputPasswordConfirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                           

{{-- 
                                                        <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" /> --}}
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">  <button type="submit" class="btn btn-primary">
                                                    {{ __('Create') }}
                                                </button></div>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- <div class="card-footer text-center py-3">
                                        <div class="small"><a class="btn btn-warning"  href="{{ route('login') }}">Already Have  Account {{ __('Login') }}</a></div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{global_asset('admin_assets\js\scripts.js')}}"></script>
    </body>
</html>
