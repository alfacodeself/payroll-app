@extends('layouts.app')

@section('content')
    <div class="container">
        <h4><span class="fw-bold">Departement</span> {{ $departement->name }}</h4>
        @include('partials.alert')
        <div class="row">
            @forelse ($departement->jobs as $job)
                <div class="col-md-4">
                    <div class="card mb-2 bg-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ $job->name }}</h5>
                            <p class="card-text">{!! $job->description !!}</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Base Salary:</strong>
                                    Rp. {{ number_format($job->base_salary, 0, ',', '.') }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Job Type:</strong> 
                                    {{ $job->job_type->name }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Status:</strong>
                                    @if ($job->status->value == 'active')
                                        <span class="badge bg-success text-uppercase">{{ $job->status }}</span>
                                    @else
                                        <span class="badge bg-danger text-uppercase">{{ $job->status }}</span>
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    <strong>Total Workers:</strong>
                                    {{ $job->employeeJobs()->count() }}
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <h6>{{ $job->created_at->diffForHumans() }}</h6>
                            <a href="">Detail Job</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 justify-content-center">
                    <h4>There's no job in this departement!</h4>
                </div>
            @endforelse
        </div>
    </div>
@endsection