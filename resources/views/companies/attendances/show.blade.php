@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Attendances Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Time</th>
                                        <th>Employee</th>
                                        <th>Qty</th>
                                        <th>Income</th>
                                        <th>Proof</th>
                                        <th>Payment Status</th>
                                        <th>Paid At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($attendances as $attendance)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $attendance->attendance_time }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('company.employees.show', [$company, $attendance->employeeJob->id]) }}">
                                                    <h6>{{ $attendance->employeeJob->employee->name }}</h6>
                                                </a>
                                                <p>
                                                    <a
                                                        href="{{ route('company.jobs.show', [$company, $attendance->employeeJob->job->slug]) }}">
                                                        {{ $attendance->employeeJob->job->name }}
                                                    </a>
                                                    -
                                                    <strong>
                                                        {{ 'Rp. ' . number_format($attendance->employeeJob->job->base_salary) }}
                                                    </strong>
                                                </p>
                                            </td>
                                            <td>{{ $attendance->job_qty }}</td>
                                            <td>
                                                <strong>
                                                    {{ 'Rp. ' . number_format($attendance->showIncome()) }}
                                                </strong>
                                            </td>
                                            <td>
                                                <a href="{{ $attendance->proof }}">Proof Link</a>
                                            </td>
                                            <td>
                                                @if ($attendance->payment_status->value == 'paid')
                                                    <span
                                                        class="badge bg-success text-uppercase py-2">{{ $attendance->payment_status }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger text-uppercase py-2">{{ $attendance->payment_status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $attendance->paid_at ?? '-' }}</td>
                                            <td class="d-flex justify-content-arround">
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#quantityModal"
                                                    onclick="openQuantityModal('{{ route('company.company.attendances.update.qty', [$company, $att, $attendance->id]) }}')">
                                                    Change Qty
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">There's no attendance</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal fade" id="quantityModal" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quantityModalLabel">Update Quantity Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="quantityForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="quantityInput" class="form-label">Quantity:</label>
                            <input type="number" class="form-control" id="quantityInput" name="qty"
                                placeholder="Enter quantity" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function openQuantityModal(url) {
            // Tangkap elemen formulir
            var quantityForm = document.getElementById('quantityForm');
            console.log(url);
            // Setel nilai atribut action formulir dengan URL yang diterima
            quantityForm.action = url;
        }
    </script>
@endpush
