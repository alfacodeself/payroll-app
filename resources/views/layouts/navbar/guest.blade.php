@if ($loginUrl != null)
    <li class="nav-item">
        <a class="nav-link" href="{{ $loginUrl }}">{{ __('Login') }}</a>
    </li>
@endif
@if ($registerUrl != null)
    <li class="nav-item">
        <a class="nav-link" href="{{ $registerUrl }}">{{ __('Register') }}</a>
    </li>
@endif
