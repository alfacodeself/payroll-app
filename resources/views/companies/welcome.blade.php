<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    @include('layouts.styles')
    <style>
        body {
            font-family: 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-weight: 700;
        }

        header.masthead {
            position: relative;
            background-color: #343a40;
            background: url({{ asset('img/payrollbanner.png') }}) no-repeat center center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            padding-top: 8rem;
            padding-bottom: 8rem;
        }

        header.masthead .overlay {
            position: absolute;
            background-color: #212529;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            opacity: 0.3;
        }

        header.masthead h1 {
            font-size: 2rem;
        }

        @media (min-width: 768px) {
            header.masthead {
                padding-top: 12rem;
                padding-bottom: 12rem;
            }

            header.masthead h1 {
                font-size: 3rem;
            }
        }

        .showcase .showcase-text {
            padding: 3rem;
        }

        .showcase .showcase-img {
            min-height: 30rem;
            background-size: cover;
        }

        @media (min-width: 768px) {
            .showcase .showcase-text {
                padding: 7rem;
            }
        }

        .features-icons {
            padding-top: 7rem;
            padding-bottom: 7rem;
        }

        .features-icons .features-icons-item {
            max-width: 20rem;
        }

        .features-icons .features-icons-item .features-icons-icon {
            height: 7rem;
        }

        .features-icons .features-icons-item .features-icons-icon i {
            font-size: 4.5rem;
        }

        .features-icons .features-icons-item:hover .features-icons-icon i {
            font-size: 5rem;
        }

        footer.footer {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }
    </style>
    @include('layouts.script')
</head>

<body>
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="#">{{ $company->name }}</a>
            @if (Route::has('company.auth.login'))
                @auth('company')
                    <a href="{{ route('company.dashboard', $company->slug) }}" class="btn btn-secondary">Dashboard</a>
                @else
                    <a href="{{ route('company.auth.login', $company->slug) }}" class="btn btn-primary">Sign In</a>
                @endauth
            @endif
        </div>
    </nav>
    <header class="masthead text-white">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <h1 class="mb-5">Lorem ipsum dolor sit amet consectetur.</h1>
                </div>
            </div>
        </div>
    </header>
    {{-- <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-screen-desktop m-auto text-primary"></i>
                        </div>
                        <h3>Fully Responsive</h3>
                        <p class="lead mb-0">This theme will look great on any device, no matter the size!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-layers m-auto text-primary"></i>
                        </div>
                        <h3>Bootstrap 4 Ready</h3>
                        <p class="lead mb-0">Featuring the latest build of the new Bootstrap 4 framework!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-check m-auto text-primary"></i>
                        </div>
                        <h3>Easy to Use</h3>
                        <p class="lead mb-0">Ready to use with your own content, or customize the source files!</p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item">
                            <a href="#">About</a>
                        </li>
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <a href="#">Contact</a>
                        </li>
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <a href="#">Terms of Use</a>
                        </li>
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <a href="#">Privacy Policy</a>
                        </li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">&copy; Your Website 2018. All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fa fa-facebook fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fa fa-twitter fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-instagram fa-2x fa-fw"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
