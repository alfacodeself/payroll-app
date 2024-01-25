<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Company, EmployeeJob, Employee, Job, AttendanceEmployee};
use App\Enums\Status;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('company.auth');
    }
    public function index(Company $company)
    {
        return view('companies.employees.index', [
            'company' => $company->slug,
            'employees' => EmployeeJob::byCompany($company->id)->orderBy('status', 'asc')->paginate(10)
        ]);
    }
    public function show(Company $company, EmployeeJob $employeeJob)
    {
        $employee = $employeeJob->load(['employee', 'job', 'attendanceEmployees.attendance', 'payrolls']);
        return view('companies.employees.show', [
            'company' => $company->slug,
            'employee' => $employee->employee,
            'job' => $employee->job,
            'attendances' => $employee->attendanceEmployees->groupBy('attendance.date'),
            'payrolls' => $employee->payrolls,
        ]);
    }
    public function create(Company $company, Request $request)
    {
        $data['company'] = $company->slug;
        if ($request->has('employee_number') && $request->employee_number != null) {
            // dd($request->all());
            $employee = Employee::where('employee_number', $request->employee_number)->first();
            if (!$employee) {
                return back()->withErrors(['employee_number' => 'Unknown employee!'])->withInput();
            }
            $data['url'] = route('company.employees.store', $company->slug);
            $data['jobs'] = Job::byCompany($company->id)->where('status', Status::ACTIVE)->get();
            $data['employee'] = $employee;
        }
        return view('companies.employees.create', $data);
    }
    public function store(Company $company, Request $request)
    {
        $request->validate([
            'employee_number' => 'required',
            'job_id' => 'required',
        ]);
        try {
            $employee = Employee::where('employee_number', $request->employee_number)->first();
            if (!$employee) {
                return back()->withErrors(['employee_number' => 'Unknown employee!'])->withInput();
            }
            $job = Job::where('slug', $request->job_id)->first();
            if (!$job) {
                return back()->withErrors(['job' => 'Unknown job!'])->withInput();
            }
            elseif ($job->status != Status::ACTIVE) {
                return back()->withErrors(['job' => 'Job is not active! Please choose another job.'])->withInput();
            }
            $checkEmployeeJob = EmployeeJob::where('employee_id', $employee->id)
                ->where('job_id', $job->id)
                ->where('status', Status::ACTIVE)
                ->first();
            if ($checkEmployeeJob) {
                return back()->with('error', 'Employee has registered on this job!');
            }
            EmployeeJob::create([
                'employee_id' => $employee->id,
                'job_id' => $job->id,
                'status' => Status::ACTIVE
            ]);
            return redirect()->route('company.employees.index', $company->slug)->with('success', 'New employee added!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function destroy(Company $company, EmployeeJob $employeeJob)
    {
        try {
            $checkJobUnpaid = AttendanceEmployee::where('employee_job_id', $employeeJob->id)
                ->where('payment_status', Status::UNPAID)
                ->first();
            if ($checkJobUnpaid) {
                return back()->with('error', 'Fail to deactivate employee. Employee has unpaid job!');
            }
            $employeeJob->updateOrFail(['status' => Status::INACTIVE]);
            return back()->with('success', 'Success deactivate employee!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
