@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.alert')
            <div class="row">
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
                                        <hr>
                                        <div class="col-md-4"><strong>Job</strong></div>
                                        <div class="col-md-8">{{ $job->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="max-height: 500px; overflow-y: auto;">
                        <!-- Card Header dengan Navigasi -->
                        <div class="card-header">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="attendance-tab" data-bs-toggle="tab" href="#attendance">Attendances</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="payrolls-tab" data-bs-toggle="tab" href="#payrolls">Payrolls</a>
                                </li>
                            </ul>
                        </div>
                
                        <!-- Konten card -->
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Tab "Attendance" -->
                                <div class="tab-pane fade show active" id="attendance">
                                    <ul>
                                        @foreach ($attendances as $key => $attendance)
                                            <li>
                                                {{ $key }}
                                                <ul>
                                                    @foreach ($attendance as $a)
                                                        <li>Time : {{ $a->attendance_time }}</li>
                                                        <li>Qty : {{ $a->job_qty }}</li>
                                                        @if ($a->proof != null)
                                                            <li>
                                                                Proof :
                                                                <a href="{{ $a->proof }}" target="__blank">
                                                                    Proof Link
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>Status : {{ $a->payment_status->value }}</li>
                                                        @if ($a->payment_status->value == 'paid')
                                                            <li>Paid At : {{ $a->paid_at }}</li>
                                                        @endif
                                                        <hr>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                
                                <!-- Tab "Payrolls" -->
                                <div class="tab-pane fade" id="payrolls">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>Proof</th>
                                                    <th>Paid At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($payrolls as $payroll)
                                                    <tr>
                                                        <td>{{ $loop->itteration }}</td>
                                                        <td>{{ $payroll->description }}</td>
                                                        <td>{{ $payroll->amount }}</td>
                                                        <td>
                                                            <a href="{{ $payroll->proof }}" target="__blank">
                                                                Link
                                                            </a>
                                                        </td>
                                                        <td>{{ $employee->paid_at }}</td>
                                                        <td class="d-flex justify-content-arround">
                                                            <a class="btn btn-sm btn-info mx-1" href="">
                                                                Detail
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">There's no payroll</td>
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
            </div>
        </div>
    </div>
@endsection
