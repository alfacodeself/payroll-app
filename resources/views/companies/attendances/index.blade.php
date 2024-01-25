@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Attendances</h5>
                        <a class="btn btn-dark" href="{{ route('company.attendances.create', $company) }}">
                            Create Attendance
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Close At</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendances->firstItem() + $loop->index }}</td>
                                            <td>{{ $attendance->date }}</td>
                                            <td>{{ $attendance->description }}</td>
                                            <td>
                                                @if ($attendance->status->value == 'opened')
                                                    <span
                                                        class="badge bg-success text-uppercase py-2">{{ $attendance->status }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger text-uppercase py-2">{{ $attendance->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $attendance->close_at }}</td>
                                            <td>{{ $attendance->created_at->diffForHumans() }}</td>
                                            <td class="d-flex justify-content-arround">
                                                <a class="btn btn-sm btn-warning mx-1" href="{{ route('company.attendances.edit', [$company, $attendance->id]) }}">
                                                    Edit
                                                </a>
                                                <a class="btn btn-sm btn-info mx-1"
                                                    href="{{ route('company.attendances.show', [$company, $attendance->id]) }}">
                                                    Detail
                                                </a>
                                                <form
                                                    action="{{ route('company.attendances.destroy', [$company, $attendance->id]) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="btn btn-sm btn-{{ $attendance->status->value == 'opened' ? 'danger' : 'success' }} mx-1"
                                                        type="submit">
                                                        {{ $attendance->status->value == 'opened' ? 'Close' : 'Open' }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">There's no attendance</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    {{ $attendances->onEachSide(3)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
