<li class="nav-item">
    <a class="nav-link" href="{{ route('company.dashboard', $company) }}">Dashboard</a>
</li>
<li class="nav-item dropdown">
    <a id="navbarMaster" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        Data Master
    </a>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarMaster">
        <a class="dropdown-item" href="{{ route('company.departements.index', $company) }}">
            Departements
        </a>
        <a class="dropdown-item" href="{{ route('company.jobs.index', $company) }}">
            Jobs
        </a>
        <a class="dropdown-item" href="{{ route('company.employees.index', $company) }}">
            Employees
        </a>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('company.attendances.index', $company) }}">Attendances</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="">Payrolls</a>
</li>
