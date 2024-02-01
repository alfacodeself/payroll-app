@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Payrolls</h5>
                        <a class="btn btn-dark" href="{{ route('company.payrolls.create', $company) }}">
                            Create Payroll
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Employee</th>
                                        <th>Description</th>
                                        <th>Total Salary</th>
                                        <th>Proof</th>
                                        <th>Paid At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payrolls as $payroll)
                                        <tr>
                                            <td>{{ $payrolls->firstItem() + $loop->index }}</td>
                                            <td>
                                                <a href="{{ route('company.employees.show', [$company, $payroll->employeeJob->id]) }}" target="__blank">
                                                    {{ $payroll->employeeJob->employee->name }}
                                                </a>
                                                <br>
                                                <a href="{{ route('company.jobs.show', [$company, $payroll->employeeJob->job->slug]) }}">
                                                    {{ $payroll->employeeJob->job->name }}
                                                    ({{ $payroll->employeeJob->job->departement->name }})
                                                </a>
                                            </td>
                                            <td>{{ $payroll->description }}</td>
                                            <td>{{ 'Rp. ' . number_format($payroll->total_amount) }}</td>
                                            <td><a href="{{ $payroll->proof }}">Proof Link</a></td>
                                            <td>
                                                {{ $payroll->paid_at }}
                                                <br>
                                                {{ $payroll->paid_at->diffForHumans() }}
                                            </td>
                                            <td class="d-flex justify-content-arround">
                                                <a class="btn btn-sm btn-info mx-1"
                                                    href="{{ route('company.payrolls.show', [$company, $payroll->id]) }}">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">There's no payroll</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    {{ $payrolls->onEachSide(3)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
