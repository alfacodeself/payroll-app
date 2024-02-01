@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Employees</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Employee</th>
                                        <th>Job</th>
                                        <th>Departement</th>
                                        <th>Status</th>
                                        <th>Entry Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $emp)
                                        <tr>
                                            <td>{{ $employees->firstItem() + $loop->index }}</td>
                                            <td>
                                                {{ $emp->employee->employee_number }}
                                                <br>
                                                <a href="{{ route('company.employees.show', [$company, $emp->id]) }}">
                                                    {{ $emp->employee->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('company.jobs.show', [$company, $emp->job->slug]) }}">
                                                    {{ $emp->job->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('company.departements.show', [$company, $emp->job->departement->slug]) }}">
                                                    {{ $emp->job->departement->name }}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($emp->status->value == 'active')
                                                    <span class="badge bg-success text-uppercase py-2">
                                                        {{ $emp->status }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger text-uppercase py-2">
                                                        {{ $emp->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $emp->created_at }}
                                                <br>
                                                {{ $emp->created_at->diffForHumans() }}
                                            </td>
                                            <td class="d-flex justify-content-arround">
                                                <a class="btn btn-sm btn-info mx-1"
                                                    href="{{ route('company.payrolls.create', [$company, 'employee' => $emp->id]) }}">
                                                    Create Payroll
                                                </a>
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
            @isset($employee)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Payroll - <strong>{{ $employee->employee->name }}</strong></h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ $url }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="employee" value="{{ $employee->id }}">
                                <h4><strong>Attendance</strong></h4>
                                @error('attendance_employee_id')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th width="15%">Salary</th>
                                                <th width="45%">Attendance Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($attendances as $attendance)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $attendance->date }}</td>
                                                    <td>{{ $attendance->description }}</td>
                                                    <td>{{ 'Rp. ' . number_format($attendance->totalIncomeUnpaidEmployee()) }}
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @forelse ($attendance->attendanceEmployees as $ae)
                                                                @if ($ae->payment_status->name != 'PAID')
                                                                    <div class="col-1">
                                                                        <input type="checkbox" name="attendance_employee_id[]"
                                                                            value="{{ $ae->id }}">
                                                                    </div>
                                                                @else
                                                                    <div class="col-1"></div>
                                                                @endif
                                                                <div class="col-11">
                                                                    <strong>
                                                                        {{ $ae->attendance_time }}
                                                                    </strong>
                                                                    <br>
                                                                    <strong>Amount</strong> :
                                                                    {{ $ae->job_qty }} X
                                                                    {{ 'Rp. ' . number_format($ae->employeeJob->job->base_salary) }}
                                                                    = {{ 'Rp. ' . number_format($ae->showIncome()) }}
                                                                    <br>
                                                                    <strong>Status</strong> :
                                                                    @if ($ae->payment_status->value == 'paid')
                                                                        <span
                                                                            class="badge bg-success text-uppercase">{{ $ae->payment_status }}</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-danger text-uppercase">{{ $ae->payment_status }}</span>
                                                                    @endif
                                                                    @if ($ae->proof != null)
                                                                        <br>
                                                                        <strong>Proof</strong> :
                                                                        <a href="{{ $ae->proof }}" target="__blank">
                                                                            Proof link
                                                                        </a>
                                                                    @endif
                                                                    <hr>
                                                                </div>
                                                            @empty
                                                                There's no attendance employee!
                                                            @endforelse
                                                        </div>
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
                                <hr>
                                <h4><strong>Additional Payroll</strong></h4>
                                <div id="additionalInputs">
                                    @if (old('additional'))
                                        @foreach (old('additional')['note'] as $key => $value)
                                            <div class="mb-2 input-group">
                                                <input type="text" class="form-control" name="additional[note][]" required
                                                    placeholder="Additional note"
                                                    value="{{ old('additional')['note'][$key] }}">
                                                <input type="number" class="form-control" name="additional[qty][]" required
                                                    placeholder="Quantity" value="{{ old('additional')['qty'][$key] }}">
                                                <input type="number" class="form-control" name="additional[base_price][]"
                                                    required placeholder="Base price"
                                                    value="{{ old('additional')['base_price'][$key] }}">
                                                <select class="form-select" name="additional[payroll_type][]" required>
                                                    <option value="additional"
                                                        {{ old('additional')['payroll_type'][$key] == 'additional' ? 'selected' : '' }}>
                                                        Additional (+)
                                                    </option>
                                                    <option value="deduction"
                                                        {{ old('additional')['payroll_type'][$key] == 'deduction' ? 'selected' : '' }}>
                                                        Deduction (-)
                                                    </option>
                                                </select>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="removeInputs(this)">Remove</button>
                                            </div>
                                            @error("additional.note.$key")
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            @error("additional.qty.$key")
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            @error("additional.base_price.$key")
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            @error("additional.payroll_type.$key")
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-primary" onclick="addInputs()">
                                    Create Additional Payroll
                                </button>
                                <hr>
                                <h4><strong>Payroll Detail</strong></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="paid_at" class="form-label">Paid At</label>
                                            <input type="datetime-local"
                                                class="form-control @error('paid_at') is-invalid @enderror" id="paid_at"
                                                name="paid_at" value="{{ old('paid_at') }}" placeholder="paid_at">
                                            @error('paid_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="proof" class="form-label">Payroll Proof</label>
                                            <input type="file" class="form-control @error('proof') is-invalid @enderror"
                                                id="proof" name="proof" value="{{ old('proof') }}" placeholder="proof">
                                            @error('proof')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-2">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" rows="3"
                                                class="form-control @error('description') is-invalid @enderror" placeholder="Payroll description...">{!! old('description') !!}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark">Submit Payroll</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection
@push('js')
    <script>
        function addInputs() {
            // Membuat grup input baru
            var newInputs = `
                <div class="mb-2 input-group">
                    <input type="text" class="form-control" name="additional[note][]" required placeholder="Additional note">
                    <input type="number" class="form-control" name="additional[qty][]" required placeholder="Quantity">
                    <input type="number" class="form-control" name="additional[base_price][]" required placeholder="Base price">
                    <select class="form-select" name="additional[payroll_type][]" required>
                        <option value="additional">Additional (+)</option>
                        <option value="deduction">Deduction (-)</option>
                    </select>
                    <button type="button" class="btn btn-danger" onclick="removeInputs(this)">Remove</button>
                </div>
            `;
            document.getElementById('additionalInputs').insertAdjacentHTML('beforeend', newInputs);
        }

        function removeInputs(button) {
            var inputGroup = button.parentNode;
            inputGroup.parentNode.removeChild(inputGroup);
        }
    </script>
@endpush
