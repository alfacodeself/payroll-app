@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Jobs</h5>
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
                                        <th>Image</th>
                                        <th>Departement</th>
                                        <th>Name</th>
                                        <th>Salary per job</th>
                                        <th>Job Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($jobs as $job)
                                        <tr>
                                            <td>{{ $jobs->firstItem() + $loop->index }}</td>
                                            <td>
                                                @if ($job->logo != null)
                                                    <a href="{{ $job->logo }}" target="__blank">Job Image</a>
                                                @else
                                                    NULL
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('company.departements.show', [$company, $job->departement->slug]) }}">{{ $job->departement->name }}</a>
                                            </td>
                                            <td>{{ $job->name }}</td>
                                            <td>{{ 'Rp. '. number_format($job->base_salary) }}</td>
                                            <td>
                                                @if ($job->job_type->value == 'daily')
                                                    <span
                                                        class="badge bg-primary text-uppercase py-2">{{ $job->job_type }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-info text-uppercase py-2">{{ $job->job_type }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($job->status->value == 'active')
                                                    <span
                                                        class="badge bg-success text-uppercase py-2">{{ $job->status }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger text-uppercase py-2">{{ $job->status }}</span>
                                                @endif
                                            </td>
                                            <td class="d-flex justify-content-arround">
                                                <a class="btn btn-sm btn-warning mx-1"
                                                    href="{{ route('company.jobs.edit', [$company, $job->slug]) }}">
                                                    Edit
                                                </a>
                                                <a class="btn btn-sm btn-info mx-1"
                                                    href="{{ route('company.jobs.show', [$company, $job->slug]) }}">
                                                    Detail
                                                </a>
                                                <form
                                                    action="{{ route('company.jobs.destroy', [$company, $job->slug]) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="btn btn-sm btn-{{ $job->status->value == 'active' ? 'danger' : 'success' }} mx-1"
                                                        type="submit">
                                                        {{ $job->status->value == 'active' ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">There's no job</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    {{ $jobs->onEachSide(3)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
