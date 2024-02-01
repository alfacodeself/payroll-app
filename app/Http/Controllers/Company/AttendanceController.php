<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Company, Attendance, AttendanceEmployee};
use App\Http\Requests\Company\AttendanceRequest;
use App\Enums\Status;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('company.auth');
    }
    public function index(Company $company)
    {
        return view('companies.attendances.index', [
            'company' => $company->slug,
            'attendances' => Attendance::where('company_id', $company->id)->paginate(10)
        ]);
    }
    public function create(Company $company)
    {
        return view('companies.attendances.create', [
            'url' => route('company.attendances.store', $company->slug)
        ]);
    }
    public function store(Company $company, AttendanceRequest $request)
    {
        try {
            $company->attendances()->create($request->validated());
            return redirect()->route('company.attendances.index', $company->slug)->with('success', 'Success create attendance');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    public function show(Company $company, Attendance $attendance)
    {
        try {
            return view('companies.attendances.show', [
                'company' => $company->slug,
                'att' => $attendance->id,
                'attendances' => $attendance->attendanceEmployees->load('employeeJob')
            ]);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function edit(Company $company, Attendance $attendance)
    {
        return view('companies.attendances.edit', [
            'url' => route('company.attendances.update', [$company->slug, $attendance->id]),
            'attendance' => $attendance
        ]);
    }
    public function update(Company $company, Attendance $attendance, AttendanceRequest $request)
    {
        try {
            $attendance->updateOrFail($request->validated());
            return redirect()->route('company.attendances.index', $company->slug)->with('success', 'Success update attendance');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    public function destroy(Company $company, Attendance $attendance)
    {
        try {
            $status = Status::CLOSED;
            $message = 'Success closed attendance!';
            if ($attendance->status == Status::CLOSED) {
                $status = Status::OPENED;
                $message = 'Success open attendance!';
            }
            $attendance->updateOrFail([
                'status' => $status,
            ]);
            return back()->with('success', $message);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function updateQty(Company $company, Attendance $attendance, AttendanceEmployee $attendanceEmployee, Request $request)
    {
        $request->validate(['qty' => 'required|integer|min:1']);
        try {
            if ($attendanceEmployee->payment_status == Status::PAID) {
                return back()->with('error', 'Attendance status is paid!');
            }
            $attendanceEmployee->updateOrFail(['job_qty' => $request->qty]);
            return back()->with('success', 'Success change qty');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
