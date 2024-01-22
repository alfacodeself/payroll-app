<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        {{ $user->name }}
    </a>
    @if ($logoutUrl != null)
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ $logoutUrl }}"
                onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ $logoutUrl }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    @endif
</li>
