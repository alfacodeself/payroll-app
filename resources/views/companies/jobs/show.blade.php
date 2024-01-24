@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Employee of <span class="fw-bold">{{ $job->name }}</span></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Employee Number</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Entry Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $employee)
                                        <tr>
                                            <td>{{ $employees->firstItem() + $loop->index }}</td>
                                            <td>{{ $employee->employee->employee_number }}</td>
                                            <td>
                                                <a href="{{ route('company.employees.show', [$company, $employee->id]) }}">
                                                    {{ $employee->employee->name }}
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
                                        </tr>
                                    @empty
                                        <tr>
                                        <td colspan="6" class="text-center">There's no employee</td>
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
