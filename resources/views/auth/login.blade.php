<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- Custom fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Styling untuk halaman */
        body {
            background: linear-gradient(to right, #4e73df, #224abe);
        }

        /* Styling untuk card login */
        .login-card {
            border-radius: 15px;
            overflow: hidden;
        }

        /* Styling untuk gambar */
        .bg-login-image {
            background: url("{{ asset('img/login-image.jpg') }}") no-repeat center center;
            background-size: cover;
            height: 100%;
            width: 100%;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
        }

        /* Mengatur padding agar lebih rapi */
        .login-form {
            padding: 40px;
        }
    </style>
</head>
<body class="bg-gradient-primary d-flex align-items-center justify-content-center vh-100"></body>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                @include('sweetalert::alert')

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card o-hidden border-0 shadow-lg my-5 login-card">
                    <div class="row no-gutters">
                        <!-- Gambar Login -->
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="bg-login-image"></div>
                        </div>

                        <!-- Form Login -->
                        <div class="col-lg-6">
                            <div class="login-form">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1>
                                </div>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group">
                                        <select class="form-control form-control-user @error('role') is-invalid @enderror" name="role" required>
                                            <option value="">-- Login sebagai Apa --</option>
                                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        @error('role')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                            placeholder="Enter Email Address..." name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                            placeholder="Password" name="password" required>
                                        @error('password')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                </form>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Create an Account!</a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
