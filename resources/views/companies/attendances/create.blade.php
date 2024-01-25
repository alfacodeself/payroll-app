@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header align-items-center">
                        <h5 class="card-title">Create Attendance</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ $url }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror"
                                            id="date" name="date" value="{{ old('date') }}" placeholder="Date">
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                            <option value="opened" {{ old('status') == 'opened' ? 'selected' : '' }}>
                                                Opened
                                            </option>
                                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>
                                                Closed
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="close_at" class="form-label">Close At</label>
                                        <input type="datetime-local"
                                            class="form-control @error('close_at') is-invalid @enderror" id="close_at"
                                            name="close_at" value="{{ old('close_at') }}" placeholder="close_at">
                                        @error('close_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" rows="6"
                                            class="form-control @error('description') is-invalid @enderror" placeholder="Job description...">{!! old('description') !!}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <small class="text-muted">
                                                Leave this field empty if you don't want to add description!
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark">Create Attendance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
