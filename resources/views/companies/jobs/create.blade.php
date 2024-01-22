@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header align-items-center">
                        <h5 class="card-title">Create Job</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="departement" class="form-label">Departement</label>
                                        <select name="departement_id" id="departement"
                                            class="form-control @error('departement_id') is-invalid @enderror">
                                            <option disabled selected>Select Departement</option>
                                            @foreach ($departements as $departement)
                                                <option value="{{ $departement->slug }}"
                                                    {{ old('departement_id') == $departement->slug ? 'selected' : '' }}>
                                                    {{ $departement->name }}
                                                    ({{ $departement->status->value }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('departement_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="Job Name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="base_salary" class="form-label">Base Salary</label>
                                        <input type="number"
                                            class="form-control @error('base_salary') is-invalid @enderror" id="base_salary"
                                            name="base_salary" value="{{ old('base_salary') }}"
                                            placeholder="Job Base Salary">
                                        @error('base_salary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="job_type" class="form-label">Job Type</label>
                                        <select name="job_type" id="job_type"
                                            class="form-control @error('job_type') is-invalid @enderror">
                                            <option value="daily" {{ old('job_type') == 'daily' ? 'selected' : '' }}>
                                                Daily
                                            </option>
                                            <option value="piecework"
                                                {{ old('job_type') == 'piecework' ? 'selected' : '' }}>
                                                Piecework
                                            </option>
                                        </select>
                                        @error('job_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" rows="7" class="form-control @error('description') is-invalid @enderror" placeholder="Job description...">{!! old('description') !!}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="logo" class="form-label">Job Image</label>
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                            id="logo" name="logo" accept="image/*" placeholder="Job Logo">
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <small class="text-muted">
                                                Leave this field empty if you don't want to add job image.
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark">Create Job</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
