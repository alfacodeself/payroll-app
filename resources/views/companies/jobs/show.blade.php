@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Employee of <span class="fw-bold">{{ $job->name }}</span></h5>
                        <A class="btn btn-dark" href="{{ route('company.jobs.create', $company) }}">
                            Create Job
                        </A>
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
                                            <td class="d-flex justify-content-arround">
                                                <a class="btn btn-sm btn-warning mx-1" href="">
                                                    Edit
                                                </a>
                                                <a class="btn btn-sm btn-info mx-1" href="">
                                                    Detail
                                                </a>
                                                <form action="" method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="btn btn-sm btn-{{ $employee->status->value == 'active' ? 'danger' : 'success' }} mx-1"
                                                        type="submit">
                                                        {{ $employee->status->value == 'active' ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
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
