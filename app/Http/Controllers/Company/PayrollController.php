<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Company, Payroll, EmployeeJob, Attendance, AttendanceEmployee, PayrollDetail};
use App\Enums\{Status, PayrollType};
use App\Http\Requests\Company\PayrollRequest;
use App\Services\FileService;
use Carbon\Carbon;

class PayrollController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->middleware('company.auth');
        $this->fileService = $fileService;
    }

    public function index(Company $company)
    {
        return view('companies.payrolls.index', [
            'company' => $company->slug,
            'payrolls' => Payroll::with('employeeJob')->paginate(10)
        ]);
    }
    public function create(Company $company, Request $request)
    {
        $data['employees'] = EmployeeJob::where('status', Status::ACTIVE)->paginate(10);
        $data['company'] = $company->slug;
        if ($request->has('employee') && $request->employee != null) {
            $employee = EmployeeJob::where('id', $request->employee)->first();
            if (!$employee) {
                return redirect()->route('company.payrolls.create', $company->slug)->with(['error' => 'Unknown employee!']);
            }
            elseif ($employee->status != Status::ACTIVE) {
                return redirect()->route('company.payrolls.create', $company->slug)->with(['error' => 'Employee inactive!']);
            }
            $data['employee'] = $employee;
            $data['attendances'] = Attendance::byUnpaidEmployeeJobId($employee->id)->get();
            $data['url'] = route('company.payrolls.store', $company->slug);
        }
        return view('companies.payrolls.create', $data);
    }
    public function store(Company $company, PayrollRequest $request)
    {
        try {
            $attendanceEmployees = $this->validateAttendance($request->attendance_employee_id);
            // Check employee job
            $employee = EmployeeJob::where('id', $request->employee)->first();
            if (!$employee) {
                return redirect()->route('company.payrolls.create', $company->slug)->with(['error' => 'Unknown employee!']);
            }
            elseif ($employee->status != Status::ACTIVE) {
                return redirect()->route('company.payrolls.create', $company->slug)->with(['error' => 'Employee inactive!']);
            }
            // Create payroll
            $payroll = Payroll::create([
                'employee_job_id' => $employee->id,
                'description' => $request->description,
                'total_amount' => $this->salaryFromAttendances($attendanceEmployees) + $this->salaryFromAdditional($request->additional),
                'proof' => $this->processLogo($request->proof, Carbon::now()->format('Ymdhi')),
                'paid_at' => $request->paid_at,
            ]);
            foreach ($attendanceEmployees as $attendanceEmployee) {
                $payrollDetail = PayrollDetail::create([
                    'payroll_id' => $payroll->id,
                    'attendance_employee_id' => $attendanceEmployee->id,
                    'base_price' => $attendanceEmployee->employeeJob->job->base_salary,
                    'qty' => $attendanceEmployee->job_qty,
                    'total' => $attendanceEmployee->showIncome(),
                    'note' => 'Attendance at - ' . $attendanceEmployee->attendance_time,
                    'payroll_type' => PayrollType::ADDITIONAL,
                ]);
                if ($payrollDetail) {
                    $attendanceEmployee->updateOrFail([
                        'payment_status' => Status::PAID,
                        'paid_at' => Carbon::now()
                    ]);
                }
            }
            // Menyiapkan data PayrollDetail untuk Additionals
            if ($request->has('additional') && $request->additional != null) {
                $additionalDetails = array_map(function ($note, $qty, $basePrice, $payrollType) use ($payroll) {
                    return [
                        'payroll_id' => $payroll->id,
                        'base_price' => $basePrice,
                        'qty' => $qty,
                        'total' => $basePrice * $qty,
                        'note' => $note,
                        'payroll_type' => PayrollType::tryFrom($payrollType),
                    ];
                }, $request->additional['note'], $request->additional['qty'], $request->additional['base_price'], $request->additional['payroll_type']);
                // Menyimpan PayrollDetails untuk Additionals
                PayrollDetail::insert($additionalDetails);
            }
            return redirect()->route('company.payrolls.index', $company->slug)->with('success', 'Success create payroll!');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    public function show(Company $company, Payroll $payroll)
    {
        return view('companies.payrolls.show', [
            'payroll' => $payroll->load('payrollDetails'),
        ]);
    }
    protected function processLogo($logo, $name, $oldLogo = null)
    {
        // Kalau ada request logo
        if ($logo && $logo != null) {
            // Jika sudah ada logo sebelumnya
            if ($oldLogo != null) {
                // Maka hapus logo
                $this->fileService->remove($oldLogo);
            }
            // Upload logo
            return $this->fileService->upload($logo, $name, 'public/img/company/payroll/');
        }
        // Kalau sebelumnya ada logo dan tidak ada request logo
        elseif ($oldLogo != null) {
            return $oldLogo;
        }
        else {
            return null;
        }
    }
    protected function validateAttendance(array $attendanceEmpployeeIds)
    {
        // Find attendance employee id
        $attendanceEmployees = AttendanceEmployee::with('employeeJob')->whereIn('id', $attendanceEmpployeeIds)->get();
        // Check paid attendance
        foreach ($attendanceEmployees as $attendanceEmployee) {
            if ($attendanceEmployee->payment_status == Status::PAID) {
                return back()->with('error', 'Attendance employee at ' . $attendanceEmployee->attendance_time . 'has been paid!');
            }
        }
        // Check count with input is same
        if ($attendanceEmployees->count() != count($attendanceEmpployeeIds)) {
            return back()->with('error', 'Unexpected attendance employee id!');
        }
        return $attendanceEmployees;
    }
    protected function salaryFromAttendances($attendanceEmployees)
    {
        $salary = 0;
        foreach ($attendanceEmployees as $attendanceEmployee) {
            $salary += $attendanceEmployee->showIncome();
        }
        return $salary;
    }
    protected function salaryFromAdditional(array $additionals = null)
    {
        if ($additionals === null) {
            return 0;
        }
        $salaries = array_map(function ($qty, $basePrice, $paymentType) {
            $multiplier = ($paymentType == PayrollType::ADDITIONAL->value) ? 1 : -1;
            return $multiplier * $qty * $basePrice;
        }, $additionals['qty'], $additionals['base_price'], $additionals['payroll_type']);
        return array_sum($salaries);
    }
}
