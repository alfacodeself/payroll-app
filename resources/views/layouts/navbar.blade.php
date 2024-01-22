@php
    $currentRoute = Route::current();
    $routeName = $currentRoute->getName();
    $parameters = $currentRoute->parameters();
    $authCompany = Auth::guard('company');
    $authAdmin = Auth::guard('admin');
    $authEmployee = Auth::guard('employee');
@endphp
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            PayrollApp
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @if ($authCompany->check())
                    @include('layouts.navbar.company', [
                        'company' => $parameters['company']->slug
                    ])
                @endif
            </ul>
            <ul class="navbar-nav ms-auto">
                @if ($authCompany->guest() && $routeName === 'company.welcome')
                    @include('layouts.navbar.guest', [
                        'loginUrl' => route('company.auth.login', $parameters['company']->slug),
                        'registerUrl' => null,
                    ])
                @elseif ($authAdmin->guest() && $routeName === 'admin.welcome')
                    @include('layouts.navbar.guest', [
                        'loginUrl' => null,
                        'registerUrl' => null,
                    ])
                @elseif ($authEmployee->guest() && $routeName === 'employee.welcome')
                    @include('layouts.navbar.guest', [
                        'loginUrl' => null,
                        'registerUrl' => null,
                    ])
                @endif

                @if ($authCompany->check())
                    @include('layouts.navbar.auth', [
                        'user' => $authCompany->user(),
                        'logoutUrl' => route('company.auth.logout', $authCompany->user()->slug),
                    ])
                @elseif ($authAdmin->check())
                    @include('layouts.navbar.auth', [
                        'user' => $authAdmin->user(),
                        'logoutUrl' => null,
                    ])
                @elseif ($authEmployee->check())
                    @include('layouts.navbar.auth', [
                        'user' => $authEmployee->user(),
                        'logoutUrl' => null,
                    ])
                @endif
            </ul>
        </div>
    </div>
</nav>
