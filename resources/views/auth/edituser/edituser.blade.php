
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <link href="/admin_assets/css/styles.css" rel="stylesheet" />
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Update Profile</h3></div>
                                    <div class="card-body">
                                        <form action={{url('/modify')}} method="POST">
                                            @csrf
                                            {{-- <pre>

                                          @php
                                              print_r($errors->all());
                                          @endphp  
                                          //code for test  validation error massage 
                                          --}}

                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                        <input  type="hidden" name="id" value="{{ $data['id'] }}" />
                                                </div>
                                                {{-- if requierd old value="{{old('name')}}" --}}
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFirstName" type="text" name="name" value="{{ $data['name'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('name')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                    </span>
                                                        <label for="inputFirstName">First name</label>
                                                       
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="email"type="email" value="{{ $data['email'] }}" />
                                                <label for="inputEmail">Email address</label>
                                                <span class="text-danger"> 
                                                    @error('email')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" 
                                                        name="password"
                                                        type="password" placeholder="Create a password" />
                                                        <span class="text-danger"> 
                                                            @error('password')
                                                            {{$message}}
                                                                
                                                            @enderror
                                                        </span>
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" type="password" name= "password_confirmation" placeholder="Confirm password" />
                                                        <span class="text-danger"> 
                                                            @error('password_confirmation')
                                                            {{$message}}
                                                                
                                                            @enderror
                                                        </span>
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit"class="btn btn-primary btn-block">Update Profile</button>
                                                    </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a  class= "btn btn-dark  "href={{url('userprofile')}}>Back</a></div>
                                    </div>
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
        <script src="js/scripts.js"></script>
    </body>
</html>
