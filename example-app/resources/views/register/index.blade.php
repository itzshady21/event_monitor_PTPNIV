<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register</title>
    <link href="{{ asset('startbootstrap/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body.bg-primary {
            background-color: #d4edda !important; /* Hijau muda */
        }
        .logo-container img {
            display: block;
            margin: 0 auto 10px auto;
            width: 60px;
            height: 60px;
        }
        .form-title {
            text-align: center;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .btn-register {
            width: 100%;
        }
        .card-footer .small a {
            text-decoration: none;
        }
    </style>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">

                                <!-- Logo & Title -->
                                <div class="card-header text-center">
                                    <div class="logo-container">
                                        <img src="http://ptpn6.com/templates/layout2020/assets/img/regional_4.png" alt="Logo">
                                    </div>
                                    <h3 class="form-title">BUAT AKUN ADMIN BARU</h3>
                                </div>

                                <div class="card-body">
                                    <form action="/register" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input class="form-control @error('name') is-invalid @enderror" name="name" id="Name" type="text" placeholder="Enter your name" required value="{{ old('name') }}"/>
                                            <label for="Name">Nama</label>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail" type="email" placeholder="name@example.com" required value="{{ old('email') }}"/>
                                            <label for="inputEmail">Email</label>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control @error('password') is-invalid @enderror" name="password" id="inputPassword" type="password" placeholder="Create a password" required/>
                                            <label for="inputPassword">Password</label>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="d-grid mt-4">
                                            <button class="btn btn-success btn-register" type="submit">Buat Akun</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="/login">Sudah Punya Akun? Login Disini!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Footer -->
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
