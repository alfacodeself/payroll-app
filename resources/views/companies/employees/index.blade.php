@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Employees</h5>
                        <a class="btn btn-dark" href="{{ route('company.employees.create', $company) }}">
                            Add Employee
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Employee Number</th>
                                        <th>Name</th>
                                        <th>Job</th>
                                        <th>Status</th>
                                        <th>Entry Date</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $employee)
                                        <tr>
                                            <td>{{ $employees->firstItem() + $loop->index }}</td>
                                            <td>{{ $employee->employee->employee_number }}</td>
                                            <td>
                                                <a href="{{ $employee->employee->photo }}" target="__blank">
                                                    {{ $employee->employee->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('company.jobs.show', [$company, $employee->job->slug]) }}">
                                                    {{ $employee->job->name }}
                                                    ({{ $employee->job->departement->name }})
                                                </a>
                                            </td>
                                            <td>
                                                @if ($employee->status->value == 'active')
                                                    <span class="badge bg-success text-uppercase py-2">
                                                        {{ $employee->status }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger text-uppercase py-2">
                                                        {{ $employee->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $employee->created_at->diffForHumans() }}</td>
                                            <td>{{ $employee->updated_at }}</td>
                                            <td class="d-flex justify-content-arround">
                                                <a class="btn btn-sm btn-info mx-1"
                                                    href="{{ route('company.employees.show', [$company, $employee->id]) }}">
                                                    Detail
                                                </a>
                                                @if ($employee->status->value == 'active')
                                                    <form
                                                        action="{{ route('company.employees.destroy', [$company, $employee->id]) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger mx-1" type="submit">
                                                            Deactivate
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">There's no employee</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    {{ $employees->onEachSide(3)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
