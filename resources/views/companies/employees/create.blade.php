@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-2">
                @include('partials.alert')
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('company.employees.create', $company) }}" method="get">
                            <div class="row">
                                <div class="col-md-10 col-12">
                                    <input type="number" name="employee_number"
                                        class="form-control @error('employee_number') is-invalid @enderror"
                                        placeholder="Employee Number"
                                        value="{{ old('employee_number', request()->employee_number) }}">
                                    @error('employee_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-dark">Search Employee</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @isset($employee)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header align-items-center">
                            <h5 class="card-title">Employee Identity</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ $employee->photo }}" alt="photo" class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4"><strong>ID</strong></div>
                                        <div class="col-md-8">{{ $employee->employee_number }}</div>
                                        <hr>
                                        <div class="col-md-4"><strong>Name</strong></div>
                                        <div class="col-md-8">{{ $employee->name }}</div>
                                        <hr>
                                        <div class="col-md-4"><strong>Phone</strong></div>
                                        <div class="col-md-8">{{ $employee->phone }}</div>
                                        <hr>
                                        <div class="col-md-4"><strong>Address</strong></div>
                                        <div class="col-md-8 text-justify">{!! $employee->address !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header align-items-center">
                            <h5 class="card-title">Add New Employee</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ $url }}" method="POST" id="formJob">
                                @csrf
                                <input type="hidden" name="employee_number" readonly value="{{ $employee->employee_number }}">
                                <div class="mb-2">
                                    <label for="job" class="form-label">Job</label>
                                    <select name="job_id" id="job"
                                        class="form-control @error('job_id') is-invalid @enderror">
                                        <option disabled selected>Select Job</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->slug }}"
                                                {{ old('job_id') == $job->slug ? 'selected' : '' }}>
                                                {{ $job->name }}
                                                -
                                                {{ Str::upper($job->departement->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('job_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-dark">Add New Employee</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection
@push('js')
@endpush
